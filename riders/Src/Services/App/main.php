<?php
namespace Moorexa\Framework;

use Src\Package\MVC\Controller;
use Container\HttpResponse;
use function Lightroom\Database\Functions\{map, db};
use function Lightroom\Requests\Functions\{post};
/**
 * Documentation for App Page can be found in App/readme.txt
 *
 *@package      App Page
 *@author       Moorexa <www.moorexa.com>
 *@author       Amadi Ifeanyi <amadiify.com>
 **/

class App extends Controller
{
    /**
    * @method App home
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/

    public function home() : void 
    {
        // dispatch event
        app('service')->addJob('service', 'event name', ['data' => 'value']);

        // 
        HttpResponse::resolve(200, ['status' => 'success']);
    }

    /**
    * @method App accountAdded
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function accountAdded()
    {
        $input = filter('POST', [
            'customerid' => 'number|required',
            'firstname' => 'string|notag|required',
            'lastname' => 'string|notag|required'
        ]);

        // form input failed
        if (!$input->isOk()) return app('response')->error('Missing required POST Data');

        // add rider
        if (db('drivers_information')->insert([
            'customerid' => $input->customerid,
            'deliveryclassid' => 0,
            'username' => $this->model->autoGenerateUsername($input->firstname, $input->lastname)
        ])->go()) :

            // send ouput
            app('response')->success('Rider account added successfully.');

        endif;
    }

    /**
    * @method App information
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function information(int $customerid = 0)
    {
        // can we continue
        if ($customerid == 0) return app('response')->error('Invalid Customerid in GET param');

        // get the driver information
        $driver = map(db('drivers_information')->get('customerid = ?', $customerid));

        // do we have this account ?
        if ($driver->rows == 0) return app('response')->error('Rider information not found.');

        // return account info
        app('response')->success([
            'information' => $driver->row()
        ]);
    }

    /**
    * @method App addDeliveryMethod
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function addDeliveryMethod()
    {
        $input = filter('POST', [
            'customerid' => 'number|required',
            'deliveryid' => 'number|required'
        ]);

        // can we continue
        if (!$input->isOk()) return app('response')->error('Invalid HTTP Request Body. Missing some required POST data');

        // update account
        $account = map(db('drivers_information')->update(['deliveryclassid' => $input->deliveryid], 'customerid = ?', $input->customerid));

        // are we good
        if ($account->ok) return app('response')->success('Delivery method updated successfully');

        // all failed
        return app('response')->error('Could not add delivery method.');
    }

    /**
    * @method App getRatings
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return mixed
    **/
    public function getRatings($riderid = 0)
    {
        $filter = filter([
            'riderid' => $riderid
        ], [
            'riderid' => 'number|required'
        ]);

        // are we good ?
        if (!$filter->isOk()) return app('response')->error('Invalid rider id');
        
        // get all ratings
        $ratings = map(db('drivers_rating')->get('customerid = ?', $riderid));

        // any record
        if ($ratings->rows == 0) return app('response')->error([
            'ratings' => 0,
            'message' => 'no ratings found'
        ]);

        // @var float $totalRatings
        $totalRatings = 0;

        // get all
        $ratings->obj(function($row) use (&$totalRatings){
            $totalRatings += floatval($row->rating);
        });

        // divide by total rows
        $totalRatings = floatval($totalRatings / ($ratings->rows + 5));

        // manage rating
        $totalRatings = ($totalRatings > 5) ? 5 : $totalRatings;

        // return ratings
        app('response')->success([
            'ratings' => $totalRatings,
            'formatted' => floor($totalRatings)
        ]);
    }

    /**
    * @method App addUsername
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function addUsername() : void
    {
        
    }

    /**
    * @method App startDelivery
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function startDelivery()
    {
        // filter input
        $input = filter('POST', [
            'tracking_number' => 'request|string|notag',
            'riderid' => 'request|number'
        ]);

        // are we good
        if (!$input->isOk()) return app('response')->error('Invalid Request Body.');

        // check tracking number
        $pickup = app('service')->runService('packages', 'find by tracking number', [
            'params' => $input->tracking_number
        ])->json;

        // are we good ?
        if ($pickup->status == 'error') return app('response')->error($pickup->message);

        // compare riderid
        if ($pickup->pickup->riderid != $input->riderid) return app('response')->error('Invalid rider ID for pickup with tracking number '.$input->tracking_number);

        // has pickup been completed
        if ($pickup->pickup->completed == 1) return app('response')->error('This pickup request has been completed. Operation failed.');

        // set rider on trip mode
        db('drivers_information')->update(['on_trip' => 1], 'customerid = ?', $input->riderid)->go();

        // all good
        app('response')->success('Rider successfully set to trip mode.');
    }
}
// END class