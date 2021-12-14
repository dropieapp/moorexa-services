<?php
namespace Src\Package;

use PDO;
use Lightroom\Core\FrameworkAutoloader;
use Lightroom\Database\{
    Interfaces\DatabaseHandlerInterface, Interfaces\ConfigurationInterface, 
    ConnectionSettings as Connection
};
/**
 * @package Moorexa Database Handler
 * @author Fregatelab <fregatelab.com>
 * @author Amadi Ifeanyi <amadiify.com>
 */
class MoorexaDatabaseHandler implements DatabaseHandlerInterface
{   
    /**
     * @method DatabaseHandlerInterface loadConfiguration
     * @param ConfigurationInterface $config
     * @param string $source
     * @return ConfigurationInterface
     */
    public function loadConfiguration(ConfigurationInterface $config, string $source = '') : ConfigurationInterface
    {
        // load configuration file
        include_once APPLICATION_ROOT . '/Database/database.php';

        if ($source == '') :
            // load from default
            $settings = Connection::getDefault();
        else :
            // load from source
            $settings = Connection::readConfiguration($source);
        endif;

        // check if configuration data was returned
        if (count($settings) > 0) :

            // set configuration with setOther
            $config->setOther($settings);

        endif;

        // register relationship directory
        FrameworkAutoloader::registerNamespace([
            'Relationships\\' => APPLICATION_ROOT . '/Database/Relationships/'
        ]);

        // return ConfigurationInterface
        return $config;
    }
}