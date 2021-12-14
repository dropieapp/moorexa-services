<?php
namespace Moorexa\Framework\Security;

use Closure;
use Src\Package\Interfaces\ControllerProviderInterface;
/**
 * Security Provider. Will be loaded before the Security controller
 * @package App provider
 */
class Provider implements ControllerProviderInterface
{
    /**
     * @method ControllerProviderInterface boot
     * @param Closure $next
     * @return void 
     *
     * This method would be called before controller renders a view
     */
    public function boot(Closure $next) : void
    {
        // call view! Applies Globally.
        $next();
    }

    /**
     * @method ControllerProviderInterface setArguments
     * @param array $arguments
     * 
     * This method sets the view arguments
     */
    public function setArguments(array $arguments) : void {}

    /**
     * @method ControllerProviderInterface viewWillEnter
     * @param string $view
     * @param array &$arguments
     * 
     * This method would be called before entering the view
     */
    public function viewWillEnter(string $view, array &$arguments)
    {
        
    }

}