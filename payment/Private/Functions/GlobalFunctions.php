<?php

use Lightroom\Adapter\{
    GlobalFunctions, Configuration\Environment, 
    ProgramFaults, Container, ClassManager
};
use Lightroom\Common\Logbook;
use Lightroom\Requests\Filter;


// global func library
function func() { return GlobalFunctions::$instance; }

// global environment getter function
function env( string $name, string $value = '' ) { return Environment::getEnv($name, $value); }

// global environment setter function
function env_set( string $name, $value = '' ) { return Environment::setEnv($name, $value); }

// global error function
function error() { return new class(){ use ProgramFaults; }; }

// load classes from container
function app(...$arguments)
{
    // method to load
    $method = count($arguments) > 0 ? 'load' : 'instance';

    // return container instance
    return call_user_func_array([Container::class, $method], $arguments);
}

// load filter handler
function filter(...$arguments) {  return call_user_func_array([Filter::class, 'apply'], $arguments); }

/**
 * @method Logbook logger
 * 
 * create logger switch function
 * this function by default, would return the default logger
 * you can pass a logger name to make a quick switch.
 */
function logger(string $logger = '')
{
    return $logger != '' ? Logbook::loadLogger($logger) : Logbook::loadDefault();
}