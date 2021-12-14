<?php
namespace Moorexa\Framework;

use Src\Package\MVC\Controller;
use Messaging\Sms as SmsBox;
use function Lightroom\Templates\Functions\{render, redirect, json, view};
/**
 * Documentation for Sms Page can be found in Sms/readme.txt
 *
 *@package      Sms Page
 *@author       Moorexa <www.moorexa.com>
 *@author       Amadi Ifeanyi <amadiify.com>
 **/

class Sms extends Controller
{
    /**
    * @method Sms home
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/

    public function home() : void 
    {
        $this->view->render('home');
    }

    /**
    * @method Sms pickupProcessed
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function pickupProcessed()
    {
        $input = filter('POST', [
            'sender_fullname' => 'required|string|notag',
            'sender_telephone' => 'required|number',
            'sender_handshake_code' => 'required|notag',
            'shortlink' => ['string|notag', 'www.dropexpress.ng']
        ]);

        // are we good ?
        if (!$input->isOk()) return app('response')->error('Missing required fields.');

        // create instance
        $sms = new SmsBox();

        // generate message
        $message = 'Hello, this is your handshake unique number '.$input->sender_handshake_code.', you will be contacted shortly for pickup. Just before releasing the package, ask for a dispatch verifcation number from the dispatch rider to ensure his/her identity and payment from dropexpress. 
        Then use any of our platforms to approve and verify pickup, or visit '.$input->shortlink.' to continue.
        Lastly, your tracking number would be sent after a successful handshake. Thank you for choosing us';

        // send message
        $sms->send($message, $input->sender_telephone);

        // all good
        app('response')->success('Message sent to ' . $input->sender_telephone);
        
    }

    /**
    * @method Sms newPickup
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function newPickup()
    {
        $input = filter('POST', [
            'sender_fullname' => 'required|string|notag',
            'telephone' => 'required|number',
            'tracking_number' => 'required|notag'
        ]);

        // are we good ?
        if (!$input->isOk()) return app('response')->error('Missing required fields.');

        // create instance
        $sms = new SmsBox();

        // generate message
        $message = 'You have a new delivery request from ' . $input->sender_fullname . '. Please Open your dropexpress account for more information. Thank you';

        // send message
        $sms->send($message, $input->telephone);

        // all good
        app('response')->success('Message sent to ' . $input->telephone);

    }

    /**
    * @method Sms riderGoneOffline
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return mixed
    **/
    public function riderGoneOffline()
    {
        // validate required inputs
        $input = filter('POST', [
            'rider_fullname' => 'required|string|notag',
            'sender_telephone' => 'required|number'
        ]);

        // are we good ?
        if (!$input->isOk()) return app('response')->error('Missing required fields.');

        // create instance
        $sms = new SmsBox();

        // generate message
        $message = 'Your selected disptach rider '.$input->rider_fullname.' just went offline. In the meantime, dropexpress would fullfill your delivery or assign the closest avaliable dispath rider around your location. Thank you for choosing us.';

        // send message
        $sms->send($message, $input->sender_telephone);

        // all good
        app('response')->success('Message sent to ' . $input->sender_telephone);
    }

    /**
    * @method Sms pickupApproved
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function pickupApproved()
    {
        // validate required inputs
        $input = filter('POST', [
            'tracking_number' => 'required|string|notag',
            'sender_telephone' => 'required|number'
        ]);

        // are we good ?
        if (!$input->isOk()) return app('response')->error('Missing required fields.');

        // create instance
        $sms = new SmsBox();

        // generate message
        $message = $input->tracking_number . ' is your tracking number. Thank you for choosing us.';

        // send message
        $sms->send($message, $input->sender_telephone);

        // all good
        app('response')->success('Message sent to ' . $input->sender_telephone);
    }
}
// END class