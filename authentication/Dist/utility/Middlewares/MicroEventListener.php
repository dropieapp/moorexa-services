<?php
namespace Moorexa\Middlewares;

use Closure;
use Lightroom\Router\Interfaces\MiddlewareInterface;
use Lightroom\Events\{Dispatcher, AttachEvent};
/**
 * @package MicroEventListener Middleware
 * @author  Moorexa inc.
 */

class MicroEventListener implements MiddlewareInterface
{
    /**
     * @method MicroEventListener request 
     * @param Closure $render
     * @return void
     * 
     * This method holds the waiting request, call render to move request to the top of the call stack.
     **/
    function request(Closure $render) : void
    {
        if (function_exists('getallheaders')) :

            // grab the request headers
            $headers = getallheaders();

            // attach event
            AttachEvent::attach(\Http\ServiceEvent::class, 'service');

            // manage the user agent 
            if (isset($headers['x-user-agent'])) $_SERVER['HTTP_USER_AGENT'] = $headers['x-user-agent'];

            // manage the ip address
            if (isset($headers['x-ip-address'])) $_SERVER['REMOTE_ADDR'] = $headers['x-ip-address'];

            // check if we have x-service-event
            if (isset($headers['x-service-event'])) :

                // dispatch event
                Dispatcher::service('receive', [
                    'event' => $headers['x-service-event'],
                    'data' => (isset($headers['x-service-data']) ? $headers['x-service-data'] : '')
                ]);

            endif;

        endif;

        // render
        $render();
    }

    /**
     * @method MicroEventListener requestClosed
     * @return void
     * 
     * This method would be called when request has been closed.
     **/
    function requestClosed() : void
    {
        // what would you like to do here?
    }

    // #cool stuffs down here
}