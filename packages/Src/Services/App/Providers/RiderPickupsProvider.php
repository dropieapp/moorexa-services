<?php
namespace Moorexa\Framework\App\Providers;

use Closure;
use Src\Package\Interfaces\ViewProviderInterface;
/**
 * @package RiderPickups View Page Provider
 * @author Moorexa <moorexa.com>
 */

class RiderPickupsProvider implements ViewProviderInterface
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
     * @method RiderPickupsProvider completed
     * @param int $riderid
     * @return void
     */
    public function completed($riderid = 0)
    {
        $input = filter([
            'riderid' => $riderid
        ], [
            'riderid' => 'number|required'
        ]);

        if ($input->isOk()) :

            // get completed pickups
            $this->model->getCompletedRiderPickups($riderid);

        endif;

        // failed
        app('response')->error('Invalid riderid. Non formatted integer sent');
    }
}