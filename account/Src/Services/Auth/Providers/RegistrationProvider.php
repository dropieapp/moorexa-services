<?php
namespace Moorexa\Framework\Auth\Providers;

use Closure;
use Moorexa\Framework\Auth\Models\{Authentication};
use Src\Package\Interfaces\ViewProviderInterface;
/**
 * @package Registration View Page Provider
 * @author Moorexa <moorexa.com>
 */

class RegistrationProvider implements ViewProviderInterface
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
     * @method RegistrationProvider dispatcher
     * @return mixed 
     */
    public function dispatcher(Authentication $model)
    {
        app('response')->resolve(200, ['status' => 'success', 'message' => 'Registration successful']);
    }

    /**
     * @method RegistrationProvider sender
     * @return mixed 
     */
    public function sender(Authentication $model)
    {
        app('response')->resolve(200, ['status' => 'success', 'message' => 'Registration successful']);
    }
}