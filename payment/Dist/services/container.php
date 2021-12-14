<?php
use Lightroom\Adapter\Container;

/**
 * @package Container bulk registry
 * @author Amadi Ifeanyi <amadiify.com>
 * 
 * Register one more class here for ease of use. Instead of importing a class, with the helper function app() you
 * can access the instance of that class, static methods and properties, public methods and properties
 */
 Container::register([
   /**
    * '<reference>' => <class>
    * 
    * Let's try this example
    * 'mysql' => Lightroom\Database\Drivers\Mysql\Driver::class 
    * 
    * Now, you can access this class with app('mysql'). There are several possibilities here,
    * Please see Lightroom\Adapter\Container for avaliable methods
    */

   // Extending support for LightQuery
   'LightQuery' => Lightroom\Database\LightQuery::class,
   'Dispatcher' => Lightroom\Events\Dispatcher::class,
   'service' => Http\ServiceEvent::class,
   'response' => Container\HttpResponse::class,
   
 ])
 // inject a container processor
 // class must extends Lightroom\Adapter\Interfaces\ContainerInterface
 ->inject([
    Src\Package\Helpers\ContainerProcessor::class
 ]);