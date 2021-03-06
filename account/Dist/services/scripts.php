<?php
use Src\Package\Helpers\ScriptManager;
/**
 * @package Script Manager
 * @author Amadi Ifeanyi <amadiify.com>
 * 
 * Here you register several scripts that would be executed from top to bottom, you can also listen for 
 * classes initialized with classManager.
 */
ScriptManager::execute([
    /**
     * @example 
     * '<method>' => ExampleNamespace\Myclass::class
     * 
     * Method should be a static public method.
     */
    'autoloadContainer' => Dist\Container::class
]);