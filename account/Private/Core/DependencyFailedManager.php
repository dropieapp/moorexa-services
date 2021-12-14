<?php
namespace Lightroom\Core;

use Exception;

/**
 * @package Dependency Manager trait
 * @author amadi ifeanyi <amadiify.com>
 * 
 * This must be used with a class that extends Exception class and implement call message method.
 */
trait DependencyFailedManager
{
    public function __construct(string $class, string $child, string $dependencyError, string $errorType = 'file', $exception = null)
    {
        // set the file and line number
        if ($exception === null) :

            // get all traces
            $traces = $this->getTrace();

            // find trace with function spl_autoload_call
            foreach ($traces as $trace) :

                if (isset($trace['function']) && $trace['function'] == 'spl_autoload_call') :

                    // update file
                    $this->file = $trace['file'];

                    // update file line
                    $this->line = $trace['line'];
                    break;

                endif;
            
            endforeach;

            // clean up
            unset($traces, $trace);

        else :

            $this->file = $exception->getFile();
            $this->line = $exception->getLine();

        endif;
        
        // set message
        $this->callException($child, $class, $dependencyError);
    }
}

