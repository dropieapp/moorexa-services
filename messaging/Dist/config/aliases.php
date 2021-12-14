<?php

/**
 * @method ConfigurationSocketInterface configurationSocket
 * 
 * Build configuration socket setting
 * We are linking this method via ConfigurationSocketHandler
 * They read a class, and class a method that in turn pushes the return value the Lightroom\Adapter\Configuration\Environment class.
 * You can acess this configurations via env(string name, mixed value);
 */
$config->configurationSocket([
	'aliase'  => $socket->setClass(Lightroom\Core\BootCoreEngine::class)->setMethod('registerAliases'),
]);


// Application Aliases
$config->aliase([
    Messaging\Mail::class => PATH_TO_UTILITY . '/Classes/Messaging/Mail.php',
    Messaging\Sms::class => PATH_TO_UTILITY . '/Classes/Messaging/Sms.php',
]);