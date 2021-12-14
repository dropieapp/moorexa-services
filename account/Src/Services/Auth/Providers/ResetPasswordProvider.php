<?php
namespace Moorexa\Framework\Auth\Providers;

use Closure;
use Src\Package\Interfaces\ViewProviderInterface;
/**
 * @package ResetPassword View Page Provider
 * @author Moorexa <moorexa.com>
 */

class ResetPasswordProvider implements ViewProviderInterface
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
}