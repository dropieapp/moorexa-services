<?php
namespace Moorexa\Framework;

use Src\Package\MVC\Controller;
use function Lightroom\Database\Functions\{db, map};
/**
 * Documentation for Realtime Page can be found in Realtime/readme.txt
 *
 *@package      Realtime Page
 *@author       Moorexa <www.moorexa.com>
 *@author       Amadi Ifeanyi <amadiify.com>
 **/

class Realtime extends Controller
{
    /**
    * @method Realtime home
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
    * @method Realtime watchman
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function watchman()
    {
        // filter the post input
        $input = filter('POST', [
            'connection' => 'string|required|min:3',
            'latitude' => 'notag',
            'longitude' => 'notag',
            'customerid' => 'number|required'
        ]);

        // can we continue
        if (!$input->isOk()) return app('response')->error('You have one or more errors in your POST data.');

        // get the driver information
        $driver = map(db('drivers_information')->get('customerid = ? and isactivated = ?', $input->customerid, 1));

        if ($driver->rows > 0) :

            // check connection status
            if ($input->connection == 'open') :

                // delivery method selected ?
                if ($driver->deliveryclassid != 0) :

                    // update account
                    $driver->update([
                        'current_longitude' => $input->longitude,
                        'current_latitude' => $input->latitude,
                        'isavaliable' => 1,
                    ]);

                    // send output
                    app('response')->success('Rider is now avaliable for pickups');

                endif;

                // send output
                app('response')->error('Rider hasn\'t selected a default delivery method.');

            else:

                // close connection
                if ($driver->on_trip == 0) :

                    // close connection now
                    $driver->update([
                        'current_longitude' => '',
                        'current_latitude' => '',
                        'isavaliable' => 0,
                    ]);

                    // send output
                    app('response')->success('Rider has gone offline.');

                endif;

                // send output
                app('response')->error('Rider can\'t go offline while on trip.');

            endif;

        else:

            // account not found
            app('response')->error([
                'code' => 419,
                'message' => 'Account not activated. Cannot go live'
            ]);

        endif;
    }

    /**
    * @method Realtime isAvaliable
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function isAvaliable($riderid)
    {
        // validate input
        $input = filter([ 'riderid' => $riderid ], [
            'riderid' => 'required|number|min:1'
        ]);

        // check if rider is currently avaliable
        if (!$input->isOk()) return app('response')->error('Invalid riderid or customerid');

        // check now
        $rider = map(db('drivers_information')->get('customerid = ?', $input->riderid));

        // are we good
        if ($rider->rows == 0) return app('response')->error('Account not found. Could not check avaliability.');

        // ok check avaliability
        if ($rider->isavaliable == '0') return app('response')->error('Rider not avaliable.');

        // avaliable
        app('response')->success('Rider is avaliable');
    }
}
// END class