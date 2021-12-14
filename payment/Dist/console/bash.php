<?php

use Classes\Cli\Assist;

/**
 * @package Bash script for assist cli manager
 * @author Amadi Ifeanyi <amadiify.com>
 * This script can contain one or more jobs for your assist command
 */
// command helper
// Within this function, you can register some default options to your assist commands
command_helper([
    'new page|new controller' => [
        '-excludeDir=Views,Custom,Packages,Static,Partials',
        function()
        {
            Assist::onDecrypt(function(&$content)
            {
                // change namespace directory
                $content = str_replace('Lightroom\Packager\Moorexa', 'Src\Package', $content);
            });
        }
    ],
    'new model|new provider' => [
        function()
        {
            Assist::onDecrypt(function(&$content)
            {
                // change namespace directory
                $content = str_replace('Lightroom\Packager\Moorexa', 'Src\Package', $content);
            });
        }
    ],
    'deploy' => [
        '--notrack'
    ]
]);

// return bash
return bash(
[
    // load default test manager for the buit in framework
    Src\Package\TestManager::class,

    // load external bash. Class must implement Classes\Cli\CliInterface
    // eg. MyNamespace\MyClass::class
],

// inline bash 
[
    // this is not a predefined command but would execute those jobs if you run 'php assist init'
    'init' => [
        'start' => [
            function()
            {
                // Set RIGHT privileges for root dir:
                Assist::runCliCommand('sudo chmod -R 777 '. $_SERVER['PWD'] . '/');
            },
            // generate unique openssl key
            'php assist generate certificate',
            // we would clean up the caching system
            'php assist cache clean',
            // we would generate a new secret key for our application and for encryption
            'php assist generate key',
            // we would generate a new secret key salt for our application and for encryption
            'php assist generate key-salt',
            // we would also generate a csrf-key to prevent our app from cross site scripting
            'php assist generate csrf-key',
            // we would also generate an assist-token for our CLI utility manager
            'php assist generate assist-token',
        ]
    ],
    // we use this for scaffolding . You can try 'php assist make auth' or basic
    'make' => [
        'start' => function(string $args, array $arguments) {
            return 'php assist scaffold:'.$args;
        }
    ],
    // we use this for running GIT jobs. basically, with this you can push your code to github. 
    // ensure you have git installed and you have remote origin configured before using this command
    // you can update it to suit your needs.
    'commit' => [
         'start' => [
             // check branch
             'git status',
             // add all files 
             'git add .',
             // commit to branch
             function ()
             {
                // get commit message
                Assist::out('Commit message (Enter new line to save or -s):'); 
                $lines = [];

                while($line = Assist::readline())
                {
                    if ( $line == '' || $line == '-s' ){  break; }
                    else{ $lines[] = $line; }
                }

                // save message 
                $message = implode("\n", $lines);

                if ($message == null || $message == '') { $message = 'initial commit.'; }

                // commit with message
                return "git commit -m '$message'";
             },
             // push commit
             'git push -f origin master'
         ]
    ],
    'conf' => [
        'start' => function(string $arg, array $args)
        {
            if ($args[0] == 'ubuntu')
            {
                // enable mod rewrite engine and add conf
                //Console\Conf\Ubuntu\UbuntuConf::mod_rewrite();

                // enable Apache’s virtual host for site domain
                Console\Conf\Ubuntu\UbuntuConf::site_default();

                // enable Apache’s secure virtual host for site domain
                //Console\Conf\Ubuntu\UbuntuConf::site_secure();
            }
        }
    ],
    // run migration for session database drivers
    'session' => [
        'start' => function()
        {
            // read env
            $driverClass = env('session', 'class');

            // check if class exists
            if (is_string($driverClass) && class_exists($driverClass)) :

                // create reflection class
                $reflection = new ReflectionClass($driverClass);

                // get file location
                $file = $reflection->getFileName();

                // get base name
                $fileName = basename($file);

                // remove base from $file, just get the directory
                $directory = rtrim($file, $fileName);

                // remove extension
                $fileName = substr($fileName, 0, strrpos($fileName, '.'));

                // use session connection identifier
                $identifier = env('session', 'identifier');

                // we have an identifier
                if (is_string($identifier) && strlen($identifier) > 1) if (!defined('USE_CONNECTION')) define('USE_CONNECTION', $identifier);

                // build command
                return 'php assist migrate '.$fileName.' -from='.$directory;
            else:

                self::out('Session driver not found. Could not run migration.');
                
            endif;
        }
    ],
    // run migration for cookie database drivers
    'cookie' => [
        'start' => function()
        {
            // read env
            $driverClass = env('cookie', 'class');

            // check if class exists
            if (is_string($driverClass) && class_exists($driverClass)) :

                // create reflection class
                $reflection = new ReflectionClass($driverClass);

                // get file location
                $file = $reflection->getFileName();

                // get base name
                $fileName = basename($file);

                // remove base from $file, just get the directory
                $directory = rtrim($file, $fileName);

                // remove extension
                $fileName = substr($fileName, 0, strrpos($fileName, '.'));

                // use cookie connection identifier
                $identifier = env('cookie', 'identifier');

                // we have an identifier
                if (is_string($identifier) && strlen($identifier) > 1) if (!defined('USE_CONNECTION')) define('USE_CONNECTION', $identifier);

                // build command
                return 'php assist migrate '.$fileName.' -from='.$directory;
            else:

                self::out('Cookie driver not found. Could not run migration.');
            endif;
        }
    ],
    // you can register more jobs here
]);