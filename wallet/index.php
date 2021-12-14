<?php

use Lightroom\{
   Core\BootCoreEngine, Core\Payload, 
   Core\PayloadRunner, Adapter\ClassManager
};

// include the init file
require_once 'init.php';

// require microservice file
require_once 'microservice.php';

/**
 * @package  Moorexa PHP Framework
 * @author   Fregatelab inc http://fregatelab.com
 * @author   Amadi ifeanyi <amadiify.com>
 * @version  0.0.1
 */

try {

   // create BootCoreEngine instance
   $engine = ClassManager::singleton(BootCoreEngine::class);

   // create Payload instance
   $payload = ClassManager::singleton(Payload::class)->clearPayloads();

   // display errors
   $engine->displayErrors(true);

   // apply default character encoding
   $engine->setEncoding('UTF-8');

   // apply default content type
   $engine->setContentType('text/html');

   /**
    * Register a default package manager
    * @package Src\Package\MicroPackager 

    * This loads the default packager for the web.
    * You can uncomment it if you don't want to use the platform launcher at this time.
    */
   $engine->defaultPackageManager($payload, Src\Package\MicroPackager::class);

   // boot application
   $engine->bootProgram($payload, ClassManager::singleton(PayloadRunner::class)->clearPayloads());

} catch (\Lightroom\Exceptions\ClassNotFound $e) {}