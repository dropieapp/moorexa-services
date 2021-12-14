<?php
namespace Moorexa\Framework\App\Providers;

use Closure;
use Http\HttpRequest;
use Src\Package\Interfaces\ViewProviderInterface;
use function Lightroom\Requests\Functions\{post};
use function Lightroom\Security\Functions\{encrypt};
/**
 * @package Paystack View Page Provider
 * @author Moorexa <moorexa.com>
 */

class PaystackProvider implements ViewProviderInterface
{
    /**
     * @var string $secretKey
     */
    private $secretKey = 'sk_test_1d0850a5e688eea65d6e994d7f13590a5285e52f';

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
     * @method PaystackProvider initialize
     * @return void
     */
    public function initialize()
    {
        // get the post data
        $post = post();

        // calculate pricing 
        $price = app('service')->runService('packages', 'calculate price', $post->all());

        // get current cost
        $cost = floatval($price->json->price) * 100;

        // paystack url
        $url = "https://api.paystack.co/transaction/initialize";

        // fields
        $fields = [
            'email' => $post->email_address,
            'amount' => $cost
        ];

        // add callback
        if ($post->has('callback_url')) $fields['callback_url'] = $post->callback_url;

        // set header
        HttpRequest::setHeader([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json'
        ]);

        // make query
        $response = HttpRequest::body($fields)->sendRequest('post', $url);

        // return response
        app('response')->success((array) $response->json);
    }

    /**
     * @method PaystackProvider verify
     * @param string $reference
     */
    public function verify(string $reference)
    {
        // set header
        HttpRequest::setHeader([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json'
        ]);

        // paystack url
        $url = "https://api.paystack.co/transaction/verify/{$reference}";

        // make request
        $response = HttpRequest::query()->sendRequest('get', $url);

        // return response
        app('response')->success((array) $response->json);
    }

    /**
     * @method PaystackProvider completed
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
        app('response')->success('Paystack payment recorded successfully.');

    }
}