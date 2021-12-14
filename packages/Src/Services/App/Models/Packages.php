<?php
namespace Moorexa\Framework\App\Models;

use Closure;
use Src\Package\{
    MVC\Model, Interfaces\ModelInterface
};
/**
 * Packages model class auto generated.
 *
 *@package App Packages Model
 *@author Amadi Ifeanyi <amadiify.com>
 **/

class Packages extends Model
{
    use \LightQuery;

    /**
     * @method ModelInterface onModelInit
     * @param ModelInterface $model
     * @param Closure $next
     * @return void
     */
    public function onModelInit(ModelInterface $model, Closure $next) : void 
    {
        // call closure
        $next();
    }

    /**
     * @method Packages getAll
     * @return void
     */
    public function getAll()
    {
        // set the delivery methods
        $this->setTable('delivery_methods');

        // fetch all
        $delivery_methods = $this->all('visible = ?', 1);

        // get all
        $data = [];

        // fetch all
        while ($row = $delivery_methods->fetch(FETCH_ASSOC)) :

            // get the url for images
            $row['delivery_white_icon'] = func()->url('Images/' . $row['delivery_white_icon']);
            
            // push data
            $data[] = $row;

        endwhile;

        // show all
        app('response')->success([
            'methods' => $data
        ]);
    }

    /**
     * @method Packages getTodayRates
     * @return void
     */
    public function getTodayRates()
    {
        // Set the default time zone
        date_default_timezone_set('Africa/Lagos');

        // set the table
        $this->setTable('delivery_rates');

        // determine the period
        $period = date('a');

        // get the hour
        $hour = intval(date('H'));

        // get the minutes
        $minutes = floatval(date('i'));

        // check
        if ($period == 'am') :

            // still in the morning
            $period = 'morning';

        else:

            // set to evening
            $period = 'evening';

            // check for hours
            if (intval($hour) <= 4) $period = 'afternoon';
            
        endif;

        // get the current day
        $day = date('Y-m-d');

        // find now
        if ($this->rows('current_day = ?', $day)) :

            // get the last query
            $query = $this->lastQuery()->fetch(FETCH_OBJ);

            // get for morning
            if ($period == 'morning') :

                // backup period
                $period = 'no rate for this period';

                // are we clear ?
                if ( ($hour >= 5 && $hour < 7)) :
                    $period = 'from_5_7_am';
                elseif ( ($hour >= 7 && $hour < 12)) :
                    $period = 'from_7_12_pm';
                endif;

            else:

                // backup period
                $period = 'no rate for this period';

                if ( ($hour >= 12 && $hour < 16)) :
                    $period = 'from_12_4_pm';
                elseif ( ($hour >= 16 && $hour < 19)):
                    $period = 'from_4_7_pm';
                elseif ( ($hour >= 19 || $hour < 22) ) :
                    $period = 'from_7_10_pm';
                endif;

            endif;

            if ($period != 'no rate for this period') :
                
                // return the rate
                app('response')->success([
                    'rate' => $query->{$period}
                ]);
            
            endif;

        endif;

        // return default
        app('response')->success([
            'rate' => 50
        ]);
    }

    /**
     * @method Packages getCompletedPickups
     * @return void
     */
    public function getCompletedRiderPickups(int $riderid)
    {
        // set the table
        $this->setTable('pickup_requests');

        // do we have an id ?
        if ($riderid < 1) return app('response')->error('Invalid rider id');

        // yes we have an id
        $pickups = $this->all('riderid = ? and completed = ?', $riderid, 1);

        // do we have something
        if ($pickups->rowCount() == 0) return app('response')->error([
            'pickups' => [],
            'message' => 'No completed pickup'
        ]);

        // share completed
        $allPickups = [];

        // get pickups
        while ($row = $pickups->fetch(FETCH_OBJ)) $allPickups[] = $row;

        // can we send ?
        app('response')->success([
            'pickups' => $allPickups,
            'total' => count($allPickups)
        ]);
    }

    /**
     * @method Packages postRequestPickup
     * @return void
     */
    public function postRequestPickup()
    {
        $input = filter('POST', [
            'customerid' => 'required|number',
            'riderid' => 'required|number',
            'amount' => 'required|notag|string',
            'sender_fullname' => 'required|notag|string',
            'sender_telephone' => 'required|number',
            'reciever_fullname' => 'required|notag|string',
            'reciever_telephone' => 'required|number',
            'delivery_methodid' => 'required|number',
            'pickup_address' => 'required|string',
            'pickup_coordinates' => 'required|string',
            'dropoff_address' => 'required|string',
            'dropoff_coordinates' => 'required|string',
            'package_hint' => ['string|required', 'no hint'],
            'coupon_code' => ['number|required|notag', '0'],
            'package_quantity' => 'required|number',
            'extra_tip' => ['number|required', '0'],
            'reference' => 'required|string|notag'
        ]);

        // are we good ?
        if (!$input->isOk()) return app('response')->error('You have an invalid post request data.');

        // get riderid copy
        $riderid = $input->riderid;

        // confirm rider avalibility
        if ($input->riderid != '0') :

            // make request
            $isAvaliable = app('service')->runService('riders', 'is rider avaliable', [
                'params' => $input->riderid
            ]);

            // are we good
            if ($isAvaliable->json->status == 'error') :

                // reset the riderid
                $input->riderid = '0';

            endif;
            
        endif;

        // set the table
        $this->setTable('pickup_requests');

        // seed 
        mt_srand(time());

        // generate the tracking number
        $input->tracking_number = 'DEX' . mt_rand(999,9999) . $input->customerid; 
        
        // generate date added
        $input->dateadded = time();

        // generate sender handshake code
        $input->sender_handshake_code = substr(str_shuffle(md5(implode(mt_rand(1,999), $input->data()))), 0, 10);

        // insert it
        $add = $this->add($input->data());

        // are we good
        if ($add) :

            // manage dispatch rider info
            $rider = 'a dropexpress dispatch rider.';

            // send sms to sender
            app('service')->addJob('messaging', 'pickup processed', [
                'sender_fullname' => $input->sender_fullname,
                'sender_telephone' => $input->sender_telephone,
                'tracking_number' => $input->tracking_number,
                'sender_handshake_code' => $input->sender_handshake_code
            ]);

            // check riderid
            if ($riderid != '0') :

                // get rider name
                $account = app('service')->runService('account', 'get information', [
                    'params' => $riderid
                ]);

                // are we good ?
                if ($account->json->status == 'success') :

                    // get the account object
                    $account = $account->json->account;

                    // get the first and last name
                    $rider = $account->firstname . ' ' . $account->lastname;

                    // are we good
                    if ($input->riderid == '0') :

                        // send sms to sender to inform him/her of the sudden change from rider
                        app('service')->addJob('messaging', 'rider gone offline', [
                            'rider_fullname' => $rider,
                            'sender_telephone' => $input->sender_telephone
                        ]);

                    else: 

                        // send sms to dispatch rider
                        app('service')->addJob('messaging', 'new pickup request', [
                            'sender_fullname' => $input->sender_fullname,
                            'telephone' => $account->telephone,
                            'tracking_number' => $input->tracking_number
                        ]);

                    endif;

                endif;

            endif;

            // show success
            app('response')->success([
                'message' => 'Pickup request sent successfully. You will be contacted by ' . $rider,
                'tracking' => $input->tracking_number,
                'riderid' => $input->riderid,
                'sender_name' => $input->sender_fullname,
                'sender_handshake_code' => $input->sender_handshake_code
            ]);

        endif;
    }
}