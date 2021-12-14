<?php
namespace Moorexa\Framework;

use Src\Package\MVC\Controller;
use Messaging\Mail as Mailer;
use function Lightroom\Security\Functions\{decrypt};
/**
 * Documentation for Mail Page can be found in Mail/readme.txt
 *
 *@package      Mail Page
 *@author       Moorexa <www.moorexa.com>
 *@author       Amadi Ifeanyi <amadiify.com>
 **/

class Mail extends Controller
{
    /**
    * @method Mail home
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/

    public function test() : void 
    {
        $mail = new Mailer();
        $mail->subject('Testing mailer')
        ->from('noreply@dropexpress.ng')
        ->to('helloamadiify@gmail.com')
        ->html(file_get_contents(HOME . '/Templates/welcome-sender.html'))
        ->send();

        app('response')->success('Hello chris!');
    }

    /**
    * @method Mail sendMailToSender
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function sendMailToSender()
    {
        // check filter
        $input = filter('POST', [
            'email' => 'email|notag|required',
            'firstname' => 'string|notag|required',
            'lastname' => 'string|notag|required',
            'activation_code' => 'required|notag',
            'referer_code' => 'required'
        ]);

        // no post data sent or not valid.
        if (!$input->isOk()) return app('response')->error('Missing required POST data. Could not send mail to sender.');

        // read template
        $template_body = file_get_contents(HOME . '/Templates/welcome-sender.html');

        //  replace placeholders
        $template_body = str_replace('{firstname}', ucfirst($input->firstname), $template_body);
        $template_body = str_replace('{referral_code}', $input->referer_code, $template_body);
        $template_body = str_replace('{activation_code}', $input->activation_code, $template_body);

        // send mail
        $mail = new Mailer();
        $mail->subject('Welcome to dropexpress logistics')
        ->from('noreply@dropexpress.ng')
        ->to($input->email)
        ->html($template_body)
        ->send();

        // show response
        app('response')->success('Mail sent to ['.$input->email.']');

    }

    /**
    * @method Mail accountLoginAlert
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function accountLoginAlert()
    {
        // check filter
        $input = filter('POST', [
            'email' => 'email|notag|required',
            'browser' => 'notag|required',
            'ipaddress' => 'notag|required',
        ]);

        // no post data sent or not valid.
        if (!$input->isOk()) return app('response')->error('Missing required POST data. Could not send account login alert.');

        // read template
        $template_body = file_get_contents(HOME . '/Templates/account-login.html');

        //  replace placeholders
        $template_body = str_replace('{browser}', $input->browser, $template_body);
        $template_body = str_replace('{ipaddress}', $input->ipaddress, $template_body);
        $template_body = str_replace('{date}', date('d/M/Y'), $template_body);
        $template_body = str_replace('{time}', date('g:i:s a'), $template_body);

        // send mail
        $mail = new Mailer();
        $mail->subject('New login activity (dropexpress)')
        ->from('noreply@dropexpress.ng')
        ->to($input->email)
        ->html($template_body)
        ->send();

        // show response
        app('response')->success('Mail sent to ['.$input->email.']');
    }

    /**
    * @method Mail sendPasswordResetMail
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function sendPasswordResetMail()
    {
        // check filter
        $input = filter('POST', [
            'email' => 'email|notag|required',
            'activation_code' => 'notag|required',
            'browser' => 'notag|required',
            'ipaddress' => 'notag|required',
        ]);

        // no post data sent or not valid.
        if (!$input->isOk()) return app('response')->error('Missing required POST data. Could not send account login alert.');

        // read template
        $template_body = file_get_contents(HOME . '/Templates/password-reset.html');

        //  replace placeholders
        $template_body = str_replace('{browser}', $input->browser, $template_body);
        $template_body = str_replace('{ipaddress}', $input->ipaddress, $template_body);
        $template_body = str_replace('{activation_code}', $input->activation_code, $template_body);

        // send mail
        $mail = new Mailer();
        $mail->subject('Password Reset Verification (dropexpress)')
        ->from('noreply@dropexpress.ng')
        ->to($input->email)
        ->html($template_body)
        ->send();

        // show response
        app('response')->success('Mail sent to ['.$input->email.']');
    }

    /**
    * @method Mail sendCompletePasswordResetMail
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function sendCompletePasswordResetMail()
    {
        // check filter
        $input = filter('POST', [
            'email' => 'email|notag|required',
            'firstname' => 'notag|required'
        ]);

        // no post data sent or not valid.
        if (!$input->isOk()) return app('response')->error('Missing required POST data. Could not send account login alert.');

        // read template
        $template_body = file_get_contents(HOME . '/Templates/password-reset-complete.html');

        //  replace placeholders
        $template_body = str_replace('{firstname}', $input->firstname, $template_body);

        // send mail
        $mail = new Mailer();
        $mail->subject('Password Reset Successful (dropexpress)')
        ->from('noreply@dropexpress.ng')
        ->to($input->email)
        ->html($template_body)
        ->send();

        // show response
        app('response')->success('Mail sent to ['.$input->email.']');
    }

    /**
    * @method Mail sendNewDownlineAlert
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function sendNewDownlineAlert()
    {
        // check filter
        $input = filter('POST', [
            'email' => 'email|notag|required',
            'firstname' => 'notag|required',
            'accountType' => 'notag|required|string',
            'referer' => 'notag|required|string',
            'lastname' => 'notag|required|string'
        ]);

        // no post data sent or not valid.
        if (!$input->isOk()) return app('response')->error('Missing required POST data. Could not send account login alert.');

        // read template
        $template_body = file_get_contents(HOME . '/Templates/downline-added.html');

        //  replace placeholders
        $template_body = str_replace('{firstname}', ucfirst($input->firstname), $template_body);
        $template_body = str_replace('{lastname}', ucfirst($input->lastname), $template_body);
        $template_body = str_replace('{referer}', ucfirst($input->referer), $template_body);
        $template_body = str_replace('{type}', ucfirst($input->accountType), $template_body);

        // send mail
        $mail = new Mailer();
        $mail->subject('You have a new downline (dropexpress)')
        ->from('noreply@dropexpress.ng')
        ->to($input->email)
        ->html($template_body)
        ->send();

        // show response
        app('response')->success('Mail sent to ['.$input->email.']');
    }

    /**
    * @method Mail sendEmailConfirmation
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function sendEmailConfirmation()
    {
        // check filter
        $input = filter('POST', [
            'email' => 'email|notag|required',
            'firstname' => 'notag|required'
        ]);

        // no post data sent or not valid.
        if (!$input->isOk()) return app('response')->error('Missing required POST data. Could not send account login alert.');

        // read template
        $template_body = file_get_contents(HOME . '/Templates/email-verified.html');

        //  replace placeholders
        $template_body = str_replace('{firstname}', ucfirst($input->firstname), $template_body);

        // send mail
        $mail = new Mailer();
        $mail->subject('Email verified (dropexpress)')
        ->from('noreply@dropexpress.ng')
        ->to($input->email)
        ->html($template_body)
        ->send();

        // show response
        app('response')->success('Mail sent to ['.$input->email.']');
    }

    /**
    * @method Mail sendOTP
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function sendOTP()
    {
        // check filter
        $input = filter('POST', [
            'email' => 'email|notag|required',
            'code' => 'number|required'
        ]);

        // no post data sent or not valid.
        if (!$input->isOk()) return app('response')->error('Missing required POST data. Could not send account login alert.');

        // read template
        $template_body = file_get_contents(HOME . '/Templates/one-time-password.html');

        //  replace placeholders
        $template_body = str_replace('{code}', $input->code, $template_body);

        // send mail
        $mail = new Mailer();
        $mail->subject('OTP notification (dropexpress)')
        ->from('noreply@dropexpress.ng')
        ->to($input->email)
        ->html($template_body)
        ->send();

        // show response
        app('response')->success('Mail sent to ['.$input->email.']');
    }
}
// END class