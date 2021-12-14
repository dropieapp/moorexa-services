<?php
namespace Moorexa\Framework;

use Src\Package\MVC\Controller;
use Container\HttpResponse;
use Moorexa\Framework\App\Providers\{PaystackProvider, WalletProvider};
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

        HttpResponse::resolve(200, ['status' => 'success']);
    }

    /**
    * @method App paystack
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function paystack(PaystackProvider $provider) : void
    {
        
    }

    /**
    * @method App wallet
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function wallet(WalletProvider $provider) : void
    {
        
    }
}
// END class