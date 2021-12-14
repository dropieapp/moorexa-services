<?php
namespace Moorexa\Framework;

use Src\Package\MVC\Controller;
use Container\HttpResponse;
use function Lightroom\Database\Functions\{map, db};
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
    * @method App authenComplete
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function authenComplete()
    {
        $input = filter('POST', [
            'customerid' => 'number|required',
            'authentication_token' => 'notag|required'
        ]);

        // process authentication
        if ($input->isOk()) :

            // doesn't exists then add
            $query = map(db('authentication')->get('customerid = ?', $input->customerid));

            if ($query->rows > 0) :

                // update token
                $query->update([
                    'authentication_token' => $input->authentication_token,
                    'last_seen' => time(),
                    'expire_at' => strtotime('+1 hour')
                ]);

            else:

                // add token
                db('authentication')->insert([
                    'customerid' => $input->customerid,
                    'authentication_token' => $input->authentication_token,
                    'last_seen' => time(),
                    'expire_at' => strtotime('+1 hour')
                ])->go();

            endif;

            // all good
            return app('response')->success('Authentication successful.');

        endif;

        // failed
        app('response')->error('Missing customerid or authentication_token.');
    }
}
// END class