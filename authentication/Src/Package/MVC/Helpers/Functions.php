<?php
namespace Lightroom\Templates\Functions;

use Lightroom\Adapter\ClassManager;
use Lightroom\Exceptions\ClassNotFound;
use Src\Package\MVC\{
    View, Controller
};
use Src\Package\Interfaces\{
    ControllerInterface
};

/**
 * @method View Handler
 * @return View
 * @throws ClassNotFound
 */
function view() : View 
{
    return ClassManager::singleton(View::class);
}

/**
 * @method Controller controller
 * @return ControllerInterface
 */
function controller() : ControllerInterface
{
    return Controller::getInstance();   
}

/**
 * @method Controller viewVariables
 * @return array
 */
function viewVariables() : array 
{
    return Controller::getViewVariables();
}

/**
 * @method Controller setViewVariables
 * @param string $variable
 * @param mixed $value
 * @return void
 */
function setViewVariable(string $variable, $value) : void 
{
    Controller::getInstance()->{$variable} = $value;
}