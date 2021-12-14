<?php
namespace Moorexa\Framework;

use Src\Package\MVC\Controller;
use Container\HttpResponse;
use function Lightroom\Database\Functions\{map, db};
use function Lightroom\Security\Functions\{encrypt};
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
    * @method App addWallet
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return mixed
    **/
    public function addWallet()
    {
        // set the timezone
        date_default_timezone_set('Africa/Lagos');

        // get the input data
        $input = filter('POST', [
            'customerid' => 'number|required'
        ]);

        // can we proceed
        if (!$input->isOk()) return app('response')->error('Invalid CustomerID.');

        // check for customer id
        $account = db('customer_wallet')->get('customerid = ?', $input->customerid)->go();

        // do we have something
        if ($account->rowCount() > 0) return app('response')->error('A Wallet account already exists for this customer.');

        // generate a unique id
        $id = intval(preg_replace('/[^\d]+/','',uniqid()));

        // generate account number 
        $number = (string) floor(abs(($id + intval($input->customerid)) - time()) / mt_rand(100, 999));

        // create wallet 
        $wallet = [
            'account_number' => (int) substr($number, 0, 7),
            'customerid' => $input->customerid,
            'wallet_pin' => md5(encrypt('0000'))
        ];

        // add wallet
        if (db('customer_wallet')->insert($wallet)->go()) app('response')->success('Wallet has been added successfully.');
    }

    /**
    * @method App fundWallet
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function fundWallet() : void
    {
        $this->view->render('fundwallet');
    }

    /**
    * @method App checkWallet
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function checkWallet($skip = false)
    {
        $input = filter('POST', [
            'account_number' => 'required|number|max:7',
            'wallet_pin' => 'number|required|min:1'
        ]);

        // are we good
        if (!$input->isOk()) return app('response')->error('Invalid Request Sent. Missing the account number');

        // try find the customer wallet information
        $wallet = map(db('customer_wallet')->get('account_number = ?', $input->account_number));

        // do we have a record
        if ($wallet->rows == 0) return app('response')->error('Could not load wallet associated to this account number.');

        // compare wallet pin
        if ($wallet->wallet_pin != md5(encrypt($input->wallet_pin))) return app('response')->error('You\'ve provided an incorrect pin');

        // all good
        if ($skip === false) return app('response')->success('Valid wallet pin.');

        // return instance
        return $wallet;
    }

    /**
    * @method App requestToken
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function requestToken() : void
    {
        $this->view->render('requesttoken');
    }

    /**
    * @method App payFromWallet
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function payFromWallet() : void
    {
        $this->view->render('payfromwallet');
    }

    /**
    * @method App wallet
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function wallet($customerid)
    {
        $input = filter([
            'customerid' => $customerid
        ], [
            'customerid' => 'required|number|min:1'
        ]);

        // are we good
        if (!$input->isOk()) return app('response')->error('Invalid customer id');

        // try find the customer wallet information
        $wallet = map(db('customer_wallet')->get('customerid = ?', $input->customerid));

        // do we have a record
        if ($wallet->rows == 0) return app('response')->error('Could not load wallet associated to this account.');

        // return wallet info
        app('response')->success([
            'walletid' => $wallet->walletid,
            'account_number' => $wallet->account_number,
            'wallet_balance' => $wallet->wallet_balance 
        ]);
    }

    /**
    * @method App initiate
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function initiate()
    {
        $input = filter('POST', [
            'account_number' => 'required|number|max:7',
            'amount' => 'required|notag'
        ]);

        // are we good
        if (!$input->isOk()) return app('response')->error('Invalid Request Sent. Missing the account number or amount');

        // check account number
        $wallet = map(db('customer_wallet')->get('account_number = ?', $input->account_number));

        // process
        if ($wallet->rows == 0) return app('response')->error('Incorrect account number.');

        // get the account information
        $info = app('service')->runService('account', 'get information', [
            'params' => $wallet->customerid
        ]);

        // are we good
        if ($info->json->status == 'success') :

            // check balance
            if (floatval($wallet->wallet_balance) < floatval($input->amount)) return app('response')->error('Insufficent wallet funds. Please fund wallet and try again.');

            // process
            $account = $info->json->account;

            // generate otp
            $otp = mt_rand(1000,9999);

            // update wallet
            $wallet->update([
                'authorization_token' => $otp
            ]);

            // send otp
            app('service')->runService('messaging', 'send otp', [
                'email' => $account->email,
                'code' => $otp
            ]);

            // all good
            return app('response')->success('A 4 digit code has been sent to ['.$account->email.']');
            
        endif;

        // failed
        app('response')->error('Account service is down. Please check back later.');
    }

    /**
    * @method App authorize
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function authorize()
    {
        $input = filter('POST', [
            'account_number' => 'required|number|max:7',
            'wallet_pin' => 'number|required|min:1',
            'otp' => 'number|required|min:1|max:4',
        ]);

        // check wallet
        $wallet = $this->checkWallet(true);

        // can we continue ?
        if (!$input->isOk()) return app('response')->error('Missing OTP. Request failed');

        // check the otp
        if ($input->otp != $wallet->authorization_token) return app('response')->error('Incorrect OTP. Process failed.');

        // so we good
        app('response')->success('Identity Verified, authorization passed');
    }

    /**
    * @method App debitWalletWithOtp
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return mixed
    **/
    public function debitWalletWithOtp()
    {
        // validate input
        $input = filter('POST', [
            'account_number' => 'required|number',
            'wallet_pin' => 'required|number',
            'otp' => 'required|number|min:4',
            'amount' => 'required|notag'
        ]);
        
        // can we proceed
        if (!$input->isOk()) return app('response')->error('Invalid or wrongly formated post data');

        // check for account
        $wallet = app('response')->callback(function(){
            return $this->checkWallet(true);
        });

        // is array ?
        if (is_array($wallet)) return app('response')->{$wallet['status']}($wallet['message']);

        // check balance
        if (floatval($wallet->wallet_balance) < floatval($input->amount)) return app('response')->error('Insufficient funds in wallet. Please fund and try again');

        // debit now
        $newBalance = abs(floatval($wallet->wallet_balance) - floatval($input->amount));

        // check otp
        if ($wallet->authorization_token != $input->otp) return app('response')->error('Incorrect authorization token. Debit request failed.');

        // debit user
        if ($wallet->update(['wallet_balance' => $newBalance])) return app('response')->success([
            'message' => 'Wallet debited successfully',
            'old_balance' => $wallet->wallet_balance,
            'new_balance' => $newBalance,
            'reference' => 'DEX' . time() * (mt_rand(1, 33)),
            'amount' => floatval($input->amount)
        ]);

        // failed
        app('response')->error('Could not debit wallet. Please try again');
    }
}
// END class