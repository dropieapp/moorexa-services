<?php
namespace Moorexa\Framework\Auth\Models;

use Closure;
use Src\Package\{
    MVC\Model, Interfaces\ModelInterface
};
use function Lightroom\Database\Functions\{db, map};
use function Lightroom\Security\Functions\{md5s, hash_password, verify_password, encrypt};
use function Lightroom\Requests\Functions\{post};
/**
 * Authentication model class auto generated.
 *
 *@package Auth Authentication Model
 *@author Amadi Ifeanyi <amadiify.com>
 **/

class Authentication extends Model
{
    use \LightQuery;

    /**
     * @method ModelInterface onModelInit
     * @param ModelInterface $model
     * @param Closure $next
     * @return void
     */
    public function onModelInit(ModelInterface $model, Closure $next) : void 
    {
        // call closure
        $next();
    }

    /**
     * @method Authentication registerAccount
     * @param string $account_type
     * @return mixed
     */
    private function registerAccount(string $account_type)
    {
        // get post data
        $input = app('filter')->registration();

        if ($input->isOk()) :

            // check password
            if ($input->password != $input->password_again) :
                 return app('response')->error('Password provided does not match.');
            endif;

            // check account information
            // be sure email doesn't exist
            $this->setTable('customers');

            // check email first
            if ($this->rows(['email' => $input->email_address]) > 0) :
                return app('response')->error('Email address already in use by another user.');
            endif;

            // check phone number
            if ($this->rows(['telephone' => $input->phone_number]) > 0) :
                return app('response')->error('Phone number already in use by another user.');
            endif;

            // check first name and lastname
            if ($this->rows(['firstname' => $input->firstname, 'lastname' => $input->lastname]) > 0) :
                return app('response')->error('Firstname and Lastname already in use by another user.');
            endif;

            // register user
            // get the account type for this user
            $accountType = map(db('account_types')->get('accounttype = ?', $account_type));

            // can we register account
            if ($accountType->rows == 0) :
                return app('response')->error('Sorry this service has been disabled for '.$account_type.' accounts.');
            endif;

            // register user
            $customerData  = [
                'firstname' => $input->firstname,
                'lastname' => $input->lastname,
                'email' => $input->email_address,
                'telephone' => $input->phone_number
            ];

            // get my referer_code
            $my_referer_code = post()->has('referer_code') ? post()->get('referer_code') : '';

            // generate referer code
            $referer_code = substr(str_shuffle(md5s(time() . implode('::', $customerData))), 0, 6);

            // set code
            $customerData['referer_code'] = $referer_code;

            // push code to post
            post()->set('referer_code', $referer_code);

            // add customer data
            $customerid = $this->add($customerData);

            // generate salt
            $customerSalt = md5s($input->email_address . mt_rand(10, 19990) . time());

            // generate activation code
            $activation_code = mt_rand(1000, 9999);

            // customer account data
            $customerAccountData = [
                'customerid' => $customerid,
                'password' => hash_password($input->password, $customerSalt),
                'securityid' => $input->security_question,
                'security_answer' => md5(encrypt($input->security_answer)),
                'date_created' => time(),
                'accounttypeid' => $accountType->accounttypeid,
                'activation_code' => $activation_code
            ];

            // add to post
            post()->set('activation_code', $activation_code);

            // add customer data
            db('customer_account')->insert($customerAccountData)->go();

            // add salt
            db('customer_salts')->insert([
                'customerid' => $customerid,
                'customer_salt' => $customerSalt
            ])->go();

            // add services
            $services = map(db('account_services')->get());

            // can we add
            if ($services->rows > 0) :

                $services->obj(function($row) use ($customerid){

                    // data
                    $data = [
                        'customerid' => $customerid,
                        'serviceid' => $row->account_serviceid,
                        'isenabled' => 1
                    ];

                    // let's add data
                    db('customer_services')->insert($data)->go();
                });

            endif;

            // add downline
            if ($my_referer_code != '') :

                // get account with referer_code
                $referer = map(db('customers')->get('referer_code = ?', $my_referer_code));

                // add downline
                if ($referer->rows > 0) :

                    // downline data
                    $downlineData = [
                        'customerid' => $referer->customerid,
                        'downlineid' => $customerid,
                        'time_registered' => time()
                    ];

                    // add downline
                    db('customer_downlines')->insert($downlineData)->go();

                    // can we send notification?
                    if (app('myservices')->enabled($referer->customerid, 'downline alert')) :

                        // send notification
                        app('service')->addJob('messaging', 'new downline added', [
                            'firstname' => $input->firstname,
                            'lastname' => $input->lastname,
                            'accountType' => $accountType->accounttype,
                            'referer' => $referer->firstname,
                            'email' => $referer->email
                        ]);

                    endif;

                endif;

            endif;

            // get the rider information
            if ($accountType->accounttype == 'rider') :

                // run driver account service
                app('service')->runService('riders', 'new account added', [
                    'customerid' => $customerid,
                    'firstname' => $input->firstname,
                    'lastname' => $input->lastname
                ]);

            endif;

            // add wallet
            app('service')->runService('wallet', 'create wallet', [
                'customerid' => $customerid
            ]);

            // account created
            return true;

        else:

            // get all fields
            $errors = array_keys($input->getErrors());

            // send response
            app('response')->success('Missing required entries ('.implode(',', $errors).')');

        endif;

        // account not created
        return false;
    }

    /**
     * @method Authentication postLogin
     * @return mixed
     */
    public function postLogin(array $authData = [])
    {
        // @var array $authData
        $authData = count($authData) == 0 ? post()->all() : $authData;

        // filter data
        $input = app('filter')->login($authData);

        // can we continue
        if ($input->isOk()) :

            // check phone
            $customer = map(db('customers')->get('email = ?', $input->username));

            // check email
            $customer = $customer->rows == 0 ? map(db('customers')->get('telephone = ?', $input->username)) : $customer;

            // check for email or phone
            if ($customer->rows > 0) :

                // get the last query
                $query = $customer;

                // get the account salt
                $salt = map(db('customer_salts')->get('customerid = ?', $query->customerid));

                // get the customer account with password
                $account = map(db('customer_account')->get('customerid = ?', $query->customerid));

                // verify password
                if (verify_password($input->password, $account->password, $salt->customer_salt)) :

                    // regenerate salt
                    $customerSalt = md5s($query->email . mt_rand(10, 19990) . time());

                    // update customer account
                    $account->update(['password' => hash_password($input->password, $customerSalt)]);

                    // update salt
                    $salt->update(['customer_salt' => $customerSalt]);

                    // get the account type
                    $accounttype = map(db('account_types')->config(['allowHTML' => true])->get('accounttypeid = ?', $account->accounttypeid));

                    // generate the authentication token
                    $token = md5(str_shuffle($customerSalt) . time() . uniqid());

                    // build response 
                    $response = [
                        'customerid' => $query->customerid,
                        'authentication_token' => $token
                    ];

                    // raise a signal
                    app('service')->runService('authentication', 'login successfull', $response);

                    // @var array $jsonData
                    $jsonData = [
                        'message' => 'Login was successful',
                        'account' => $query->row(),
                        'response' => $response,
                        'accountType' => $accounttype->accounttype,
                        'isactivated' => $account->isactivated,
                        'agreed_to_terms' => $account->agreed_to_terms
                    ];

                    

                    // can we add the terms
                    if ($account->agreed_to_terms == 0) :

                        // add terms and condition
                        $jsonData['terms_and_conditions'] = $accounttype->terms_and_conditions;

                    endif;

                    // can we send login alert?
                    if (app('myservices')->enabled($query->customerid, 'login alert')) :

                        // send notification
                        app('service')->addJob('messaging', 'new account login', [
                            'email' => $customer->email,
                            'browser' => $_SERVER['HTTP_USER_AGENT'],
                            'ipaddress' => $_SERVER['REMOTE_ADDR']
                        ]);

                    endif;

                    // all good
                    app('response')->success($jsonData);

                    // return response
                    return $jsonData;

                endif;

                // incorrect password
                app('response')->error('Password provided is wrong. Please check and try again');

            endif;

            // Account not found
            app('response')->error('Invalid email address or telephone. Account not found!');

        else:   

            // could not process user account
            app('response')->error('Invalid login credentials submitted');

        endif;

        // return false
        return false;
    }

    /**
     * @method Authentication putSender
     * @return void
     */
    public function putSender()
    {
        $this->registerUser('sender');
    }

    /**
     * @method Authentication putDispatcher
     * @return void
     */
    public function putDispatcher()
    {
        $this->registerUser('rider');
    }

    /**
     * @method Authentication postResetPassword
     * @return mixed
     */
    public function postResetPassword()
    {
        // filter data
        $input = app('filter')->resetPassword();

        // all failed
        if (!$input->isOk()) return app('response')->error('Invalid request data submitted. Failed to process reset');

        // check if account exists
        $account = map(db('customers')->get('email = ? or telephone = ?', $input->username, $input->username));

        // account not found ?
        if ($account->rows == 0) return app('response')->error('Incorrect email or telephone. Account does not exists.');

        // check security question and answer
        $customer_data = $account->from('customer_account', 'customerid')->get();

        // compare securityid
        if ($customer_data->securityid != $input->security_question) return app('response')->error('Incorrect Security question for this account.');

        // compare the security answer
        if (md5(encrypt($input->security_answer)) != $customer_data->security_answer) return app('response')->error('Incorrect security answer. Password reset failed.');

        // generate code
        $activation_code = mt_rand(1000, 9000);

        // send signal
        app('service')->runService('messaging', 'new password reset', [
            'firstname' => $account->firstname,
            'lastname' => $account->lastname,
            'email' => $account->email,
            'activation_code' => $activation_code,
            'ipaddress' => $_SERVER['REMOTE_ADDR'],
            'browser' => $_SERVER['HTTP_USER_AGENT']
        ]);

        // all good
        app('response')->success([
            'message' => 'One more step to go, level one identity verified. Please check your mail ['.$account->email.'] for your level two verification code.',
            'customerid' => $account->customerid,
            'activation_code' => $activation_code
        ]);
    }

    /**
     * @method Authentication postCompleteResetPassword
     * @return mixed
     */
    public function postCompleteResetPassword()
    {
        // filter data
        $input = app('filter')->completeResetPassword();

        // show error
        if (!$input->isOk()) return app('response')->error('Invalid Customerid or new password');

        // process password reset
        $account = map(db('customer_account')->get('customerid = ?', $input->customerid));

        // does account exists
        if ($account->rows == 0) return app('response')->error('Invalid user, account wasn\'t found and password reset was terminated.');

        // generate salt
        $customerSalt = md5s($account->password . mt_rand(10, 19990) . time());

        // generate a new password
        $account->update([
            'password' => hash_password($input->new_password, $customerSalt)
        ]);

        // update customer salt
        db('customer_salts')->update(['customer_salt' => $customerSalt], 'customerid = ?', $input->customerid)->go();

        // get account info
        $info = $account->from('customers', 'customerid')->get();

        // raise signal
        app('service')->addJob('messaging', 'password reset complete', [
            'email' => $info->email,
            'firstname' => $info->firstname,
            'lastname' => $info->lastname
        ]);

        // all good
        app('response')->success('Your password has been changed successfully.');

    }

    /**
     * @method Authentication registerUser
     * @param string $accountType
     */
    private function registerUser(string $accountType)
    {
        // account registered
        if ($this->registerAccount($accountType)) :

            // build login data
            $loginData = [
                'username' => post()->email_address,
                'password' => post()->password
            ];

            // send welcome email
            app('service')->runService('messaging', 'new '.$accountType.' mail', [
                'email' => post()->email_address,
                'firstname' => post()->firstname,
                'lastname' => post()->lastname,
                'activation_code' => post()->activation_code,
                'referer_code' => post()->referer_code
            ]);

            // login this user
            return $this->postLogin($loginData);

        endif;

        // registration failed
        app('response')->error('Registration failed. Please check back. Seems like the service is down.');
    }
}