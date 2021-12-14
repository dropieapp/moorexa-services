<?php
namespace Moorexa\Framework;

use Src\Package\MVC\Controller;
use Moorexa\Framework\Auth\Models\{Authentication};
use function Lightroom\Database\Functions\{db};
/**
 * Documentation for Auth Page can be found in Auth/readme.txt
 *
 *@package      Auth Page
 *@author       Moorexa <www.moorexa.com>
 *@author       Amadi Ifeanyi <amadiify.com>
 **/

class Auth extends Controller
{
    /**
    * @method Auth register
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function register(Auth\Providers\RegistrationProvider $provider) : void 
    {
        
    }

    /**
    * @method Auth login
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function login(Authentication $model) : void
    {
        
    }

    /**
    * @method Auth resetPassword
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function resetPassword(Authentication $model, Auth\Providers\ResetPasswordProvider $provider) : void
    {
       
    }

    /**
    * @method Auth completeResetPassword
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function completeResetPassword(Authentication $model) : void
    {
        
    }

    /**
    * @method Auth processActivation
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function processActivation(Authentication $model)
    {
        $input = filter('POST', [
            'activation_code' => 'required|notag|min:4'
        ]);

        // are we good
        if (!$input->isOk()) return app('response')->error('Invalid Activation code. Process failed');

        // set the table
        $model->setTable('customer_account');

        // find accounts with activation code
        $account = $model->all('activation_code = ?', $input->activation_code);

        // do we have a record
        if ($account->rowCount() == 0) return app('response')->error('User account not found. We could not proceed with the activation.');

        // activate user account
        if ($model->update(['isactivated' => 1], 'activation_code = ?', $input->activation_code)) :

            // get the customer id
            $customerid = $account->fetch(FETCH_OBJ)->customerid;

            // change state
            $model->setTable('customers');

            // get the customer info
            $info = $model->all('customerid = ?', $customerid)->fetch(FETCH_OBJ);

            // send signal for messaging
            app('service')->addJob('messaging', 'email approved', [
                'firstname' => $info->firstname,
                'email' => $info->email
            ]);
            
            // email verified response.
            return app('response')->success('Your email address has been verified successfully.');

        endif;

        // failed
        app('response')->error('Activation failed. Please try again later');

    }

    /**
    * @method Auth agreeToTerms
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function agreeToTerms($customerid = 0) : void
    {
        if (intval($customerid) > 0) :

            // agreed to terms
            db('customer_account')->update(['agreed_to_terms' => 1], 'customerid = ?', $customerid)->go();

            // all good
            app('response')->success('Agreed to terms successfully');

        endif;

        // resolve with an error
        app('response')->error('invalid customer id');
    }
}
// END class