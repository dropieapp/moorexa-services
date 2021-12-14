<?php
namespace Moorexa\Framework;

use Src\Package\MVC\Controller;
use function Lightroom\Templates\Functions\{render, redirect, json, view};
/**
 * Documentation for Requests Page can be found in Requests/readme.txt
 *
 *@package      Requests Page
 *@author       Moorexa <www.moorexa.com>
 *@author       Amadi Ifeanyi <amadiify.com>
 **/

class Requests extends Controller
{
    /**
    * @method Requests home
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/

    public function home() : void 
    {
       
    }

    /**
    * @method Requests info
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function info()
    {
        // verify input
        $input = filter('POST', [
            'riderid' => 'required|number',
            'tracking_number' => 'required|string|notag'
        ]);

        // are we good
        if (!$input->isOk()) return app('response')->error('Unknown riderid or tracking number');

        // find by tracking number
        $tracking = app('service')->runService('packages', 'find by tracking number', [
            'params' => $input->tracking_number
        ]);

        // check tracking
        if ($tracking->json->status == 'error') return app('response')->error($tracking->json->message);

        // check riderid
        if ($input->riderid != $tracking->json->pickup->riderid) return app('response')->error('Delivery with this tracking number #'.$input->tracking_number.' is not assigned to this rider.');

        // return response
        app('response')->success(func()->toArray($tracking->json));
    }
}
// END class