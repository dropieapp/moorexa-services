<?php

use Lightroom\Core\FrameworkAutoloader;

/**
 * @package Application base file
 * This file would contain some basic settings to boot the moorexa framework
 */

// define application root 
define('APPLICATION_ROOT', './');

// define base path for framework system files
define('FRAMEWORK_BASE_PATH', 'Private');

// define distribution base path.
// this folder contains configuration directory, components, database, extensions, public, services and much more
// it's advisable you change it, including the framework base path after obtaining a copy of moorexa.
// We are doing this just to add an extra layer of security, so you stay unique and invisible.
define('DISTRIBUTION_BASE_PATH', 'Dist');

// composer path
define('COMPOSER', APPLICATION_ROOT . 'vendor/autoload.php');

// require framework autoloader
require_once FRAMEWORK_BASE_PATH . '/Core/FrameworkAutoloader.php';

// register default namespace for application
FrameworkAutoloader::registerNamespace([ 

    // Lightroom namespace for the Moorexa framework
    'Lightroom\\' => FRAMEWORK_BASE_PATH,
])
->registerAutoloader()->secondaryAutoloader(function(){
    
    // composer autoloader
    $this->autoloadRegister(APPLICATION_ROOT . 'vendor/autoload.php');
})
// register push event for autoloadFailed events.
->registerPusherEvent();

// define controller root directory
define('CONTROLLER_ROOT', APPLICATION_ROOT . '/Src/Services');


// sub directories for controllers.
// This defines the folder names for models, views, custom (for header and footer), packages, partials, static and more
define('CONTROLLER_MODEL',      'Models');
define('CONTROLLER_VIEW',       'Views');
define('CONTROLLER_CUSTOM',     'Custom');
define('CONTROLLER_PACKAGE',    'Packages');
define('CONTROLLER_PARTIAL',    'Partials');
define('CONTROLLER_STATIC',     'Static');
define('CONTROLLER_PROVIDER',   'Providers');
