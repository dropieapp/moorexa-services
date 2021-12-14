<?php
namespace Resources;

use Src\Package\RouterMethods;
use Src\Package\Interfaces\ResourceInterface;
use function Lightroom\Database\Functions\{map, db};
/**
 * @package Resources Pickup
 * @author Amadi Ifeanyi <amadiify.com>
 */
class Pickup implements ResourceInterface
{
    /**
     * @var string $table
     */
    private $table = 'pickup_requests';

    /**
     * @method ResourceInterface onRequest
     * @param RouterMethods $method
     * @return void
     * 
     * Here is a basic example of how this works.
     * $method->get('hello/{name}', 'methodName');
     * 
     * Where "methodName" is a public method within class.
     * Hope it's simple enough?
     */
    public function onRequest(RouterMethods $method) : void
    {
        // find by tracking number
        $method->get('find-by-tracking-number/{tracking_number}', 'findByTrackingNumber');

        // find by dispatch code
        $method->get('find-by-dispatch-code/{dispatch_code}/{riderid}', 'findByDispatchCode');

        // find by handshake code
        $method->get('find-by-handshake-code/{handshake_code}', 'findByHandShakeCode');

        // get unapproved pickup request count for riders
        $method->get('get-unapproved-request-count/{riderid}', 'getUnapprovedRiderRequestsCount');

        // get unapproved pickup requests
        $method->get('get-rider-unapproved-requests/{riderid}', 'getUnapprovedRiderRequests');

        // get approved pickup requests
        $method->get('get-rider-approved-requests/{riderid}', 'getApprovedRiderRequests');

        // approved rider pickup request
        $method->post('approve-rider-pickup-request', 'approvePickupRequestForRider');

        // approve sender pickup request
        $method->post('approve-sender-pickup-request', 'approvePickupRequestForSender');
    }

    /**
     * @method Pickup findByTrackingNumber
     * @param string $tracking_number
     * @return mixed
     */
    public function findByTrackingNumber($tracking_number)
    {
        // check tracking number
        $input = filter(['trackingNumber' => $tracking_number], [
            'trackingNumber' => 'string|required|notag'
        ]);

        // are we good 
        if (!$input->isOk()) return app('response')->error('Invalid Tracking number');

        // check now 
        $request = map(db($this->table)->get('tracking_number = ?', $input->trackingNumber));

        // no record ?
        if ($request->rows == 0) return app('response')->error('Invalid Tracking number');

        // show record
        app('response')->success(['pickup' => $request->row()]);
    }

    /**
     * @method Pickup findByDispatchCode
     * @param string $dispatch_code
     * @return mixed
     */
    public function findByDispatchCode($dispatch_code, $riderid)
    {
        // check tracking number
        $input = filter([
            'dispatch_code' => $dispatch_code,
            'riderid' => $riderid], [
            'dispatch_code' => 'number|required',
            'riderid' => 'number|required'
        ]);

        // are we good 
        if (!$input->isOk()) return app('response')->error('Invalid Dispatch code or rider id');

        // check now 
        $request = map(db($this->table)->get('dispatch_code = ? and riderid = ?', $input->dispatch_code, $input->riderid));

        // no record ?
        if ($request->rows == 0) return app('response')->error('Invalid dispatch code for rider. No record found.');

        // show record
        app('response')->success(['pickup' => $request->row()]);
    }

    /**
     * @method Pickup getUnapprovedRiderRequestsCount
     * @param int $riderid
     * @return mixed
     */
    public function getUnapprovedRiderRequestsCount($riderid)
    {
        // check for riderid
        $input = filter(['riderid' => $riderid], ['riderid' => 'number|required']);

        // are we good
        if (!$input->isOk()) return app('response')->error('Invalid Rider id');

        // make request
        $requests = map(db($this->table)->get('riderid = ? and approved = ?', $input->riderid, 0));

        // return report
        app('response')->success(['total' => $requests->rows]);
    }

    /**
     * @method Pickup getUnapprovedRiderRequestss
     * @param int $riderid
     * @return mixed
     */
    public function getUnapprovedRiderRequests($riderid)
    {
        // check for riderid
        $input = filter(['riderid' => $riderid], ['riderid' => 'number|required']);

        // are we good
        if (!$input->isOk()) return app('response')->error('Invalid Rider id');

        // make request
        $requests = db($this->table)->get('amount, sender_fullname, dateadded, tracking_number', 'riderid = ? and approved = ?', $input->riderid, 0)->go();

        // do we have any
        if ($requests->rowCount() == 0) return app('response')->error('No unapproved pickup request at this time. All good.');

        // get pending requests
        $rows = [];

        // run through
        while ($row = $requests->fetch(FETCH_ASSOC)) :

            // update amount, calculate for 15%
            $commision = (floatval($row['amount']) * 15) / 100;

            // subtract commission
            $row['amount'] = (floatval($row['amount']) - $commision);

            // add to rows
            $rows[] = $row;

        endwhile;

        // return rows
        app('response')->success(['pickup' => $rows]);

    }

    /**
     * @method Pickup getApprovedRiderRequests
     * @param int $riderid
     * @return mixed
     */
    public function getApprovedRiderRequests($riderid)
    {
        // check for riderid
        $input = filter(['riderid' => $riderid], ['riderid' => 'number|required']);

        // are we good
        if (!$input->isOk()) return app('response')->error('Invalid Rider id');

        // make request
        $requests = db($this->table)->get('riderid = ? and approved = ?', $input->riderid, 1)->go();

        // do we have any
        if ($requests->rowCount() == 0) return app('response')->error('No approved pickup request at this time. All good.');

        // get pending requests
        $rows = [];

        // run through
        while ($row = $requests->fetch(FETCH_ASSOC)) :

            // update amount, calculate for 15%
            $commision = (floatval($row['amount']) * 15) / 100;

            // subtract commission
            $row['amount'] = (floatval($row['amount']) - $commision);

            // add to rows
            $rows[] = $row;

        endwhile;

        // return rows
        app('response')->success(['pickup' => $rows]);

    }

    /**
     * @method Pickup approvePickupRequestForRider
     * @return mixed
     */
    public function approvePickupRequestForRider()
    {
        // verify input
        $input = filter('POST', [
            'riderid' => 'required|number|notag',
            'tracking_number' => 'required|string|notag'
        ]);

        // check are we ok
        if (!$input->isOk()) return app('response')->error('Invalid Request Data. Validation failed.');

        // check to know if this request hasn't been verified previously
        $request = map(db($this->table)->get($input->data()));

        // are we good ?
        if ($request->rows == 0) return app('response')->error('We could not find a record matching the information provided.');

        // is approved previously
        if ($request->approved == 1) return app('response')->error('This pickup request has been approved previously.');

        // generate a dispatch code
        mt_srand(time());

        // genrate random number
        $rand = (string) mt_rand(1010, time());
        $dispatch_code = substr(str_shuffle($rand), 0, 4);

        // approve now
        $request->update([
            'approved' => 1,
            'dispatch_code' => $dispatch_code,
            'time_approved' => time()
        ]);

        // respond with disptach code
        app('response')->success(['dispatch_code' => $dispatch_code, 'sender_name' => $request->sender_fullname]);

    }

    /**
     * @method Pickup findByHandShakeCode
     * @param string $handshakeCode
     * @return mixed
     */
    public function findByHandShakeCode($handshakeCode)
    {
        // filter 
        $input = filter(['handshake_code' => $handshakeCode], [
            'handshake_code' => 'required|notag|string'
        ]);

        // are we good?
        if (!$input->isOk()) return app('response')->error('Invalid HandShake code provided.');

        // make query
        $request  = db($this->table)->get('sender_handshake_code = ?', $input->handshake_code)->go();

        // do we have a record?
        if ($request->rowCount() == 0) return app('response')->error('Invalid handshake code provided. No record found!');

        // fetch record
        $record = $request->fetch(FETCH_OBJ);

        // get the delivery method
        $delivery = db('delivery_methods')->get('delivery_methodid = ?', $record->delivery_methodid)->go()->fetch(FETCH_OBJ);

        // get rider information
        $fulfilledBy = 'dropexpress';

        // try load account information
        if ($record->riderid != '0') :

            // request account information
            $account = app('service')->runService('account', 'get information', [
                'params' => $record->riderid
            ])->json;

            // do we have something
            if ($account->status != 'error') $fulfilledBy = ucwords( $account->account->lastname . ' ' . $account->account->firstname);

        endif;

        // add delivery method
        $record->deliveryMethod = $delivery->delivery_method;

        // add fulfilledBy
        $record->fulfilledBy = $fulfilledBy;

        // send response
        app('response')->success(['pickup' => (array) $record]);
    }

    /**
     * @method Pickup approvePickupRequestForSender
     * @return mixed
     */
    public function approvePickupRequestForSender()
    {
        // verify post data
        $input = filter('POST', [
            'handshake_code' => 'required|string|notag',
            'dispatch_code' => 'required|number|min:4'
        ]);

        // are we good
        if (!$input->isOk()) return app('response')->error('Invalid Request data. Missing handshake or dispatch code.');

        // now we verify
        $pickup = map(db($this->table)->get('sender_handshake_code = ? and dispatch_code = ?', $input->handshake_code, $input->dispatch_code));

        // are we good ?
        if ($pickup->rows == 0) return app('response')->error('Invalid Handshake or dispatch code.');

        // approve now
        $pickup->update([
            'handshake_made' => 1
        ]);

        // send message
        app('service')->addJob('messaging', 'pickup approved', [
            'sender_telephone' => $pickup->sender_telephone,
            'tracking_number' => $pickup->tracking_number
        ]);

        // set rider on trip
        app('service')->runService('riders', 'start delivery', [
            'tracking_number' => $pickup->tracking_number,
            'riderid' => $pickup->riderid
        ]);

        // done!
        app('response')->success('Pickup request approved.');
    }
}