<?php
namespace Dist;

use Lightroom\Adapter\Container as GlobContainer;
/**
 * @package Container for autoloading
 * @author Amadi Ifeanyi <amadiify.com>
 */
class Container
{
    /**
     * @method Container autoloadContainer
     * @return void
     */
    public static function autoloadContainer() : void
    {
        // load container.json if exists
        $containerJson = HOME . 'container.json';

        // can we load
        if (file_exists($containerJson)) :

            // get json object
            $containers = json_decode(file_get_contents($containerJson));

            // cast array
            if (is_object($containers)) $containers = func()->toArray($containers);

            // register containers if array
            if (is_array($containers)) GlobContainer::register($containers);

        endif;
    }
}