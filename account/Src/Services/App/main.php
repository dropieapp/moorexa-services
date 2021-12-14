<?php
namespace Moorexa\Framework;

use Src\Package\MVC\Controller;
use Container\HttpResponse;
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
        // app('service')->addJob('service', 'event name', ['data' => 'value']);

        HttpResponse::resolve(200, ['status' => 'success']);
    }

    /**
    * @method App authenticate
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function authenticate() : void
    {
        app('response')->resolve(200, ['status' => 'success']);   
    }

    /**
    * @method App account
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function account()
    {
        // get the customer account info
    }
}
// END class