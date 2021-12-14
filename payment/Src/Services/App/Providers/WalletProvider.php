<?php
namespace Moorexa\Framework\App\Providers;

use Closure;
use Src\Package\Interfaces\ViewProviderInterface;
use function Lightroom\Requests\Functions\{post};
use function Lightroom\Security\Functions\{encrypt};
/**
 * @package Wallet View Page Provider
 * @author Moorexa <moorexa.com>
 */

class WalletProvider implements ViewProviderInterface
{
    /**
     * @method ViewProviderInterface setArguments
     * @param array $arguments
     * 
     * This method sets the view arguments
     */
    public function setArguments(array $arguments) : void {}

    /**
     * @method ViewProviderInterface viewWillEnter
     * @param Closure $next
     * 
     * This method would be called before rendering view
     */
    public function viewWillEnter(Closure $next) : void
    {
        // route passed
        $next();
    }

    /**
     * @method WalletProvider initialize
     * @return void
     */
    public function initialize()
    {
        // get the post data
        $post = post();

        // calculate pricing 
        $price = app('service')->runService('packages', 'calculate price', $post->all());

        // get current cost
        $cost = floatval($price->json->price);

        // debit wallet
        $wallet = app('service')->runService('wallet', 'debit wallet with otp', [
            'amount' => $cost,
            'account_number' => $post->account_number,
            'wallet_pin' => $post->wallet_pin,
            'otp' => $post->otp
        ]);

        // output response
        app('response')->{$wallet->json->status}(func()->toArray($wallet->json));
    }

    /**
     * @method WalletProvider completed
     * @return void
     */
    public function completed()
    {
        $input = filter('POST', [
            'verification' => 'notag|required',
            'reference' => 'notag|required'
        ]);

        // not cool
        if (!$input->isOk()) return app('response')->error('Missing verification data or reference data');

        // encrypt verification body
        $input->verification = encrypt($input->verification);

        // add date submited
        $input->datesubmitted = time();

        // process payment
        $this->controller->model->paymentCompleted($input->data());

        // all good
        app('response')->success('Wallet payment recorded successfully.');

    }
}