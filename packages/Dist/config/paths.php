<?php

/**
 * *************************
 * We would begin application boot process by extablishing all the required paths.
 * For this, we would use the GlobalConstants class
 */
use Lightroom\Core\{
    GlobalConstants, Setters\Constants
};
use Lightroom\Adapter\GlobalVariables as GlobalVars;

/**
 * ****************
 * First, we create an instance of global constants 
 * We would be needing this prefix for all our application path
 */
$global = GlobalVars::var_set('global-constant', new GlobalConstants());
$constant = new Constants();

/**
 * *******
 * Create base path
 */
$base = $global->newConstant($constant->name('Home')->value(APPLICATION_ROOT));

/**
 * *******
 * Add path prefix for constant
 */
$base->createPrefix('PATH_TO_');

/**
 * *******
 * Add suffix for path constants
 * we add a trailing forward slash to keep our path valid.
 */
$base->createSuffix('/');

/**
 * ********
 * Create controller base path
 */
$base->fromConstant($constant->name('web_platform')->value(CONTROLLER_ROOT));

/**
 * ********
 * Create system path
 */
$system = $base->fromConstant($constant->name('system')->value(FRAMEWORK_BASE_PATH));

/**
 * ********
 * Create kernel path
 */
$kernel = $base->fromConstant($constant->name('kernel')->value(DISTRIBUTION_BASE_PATH));

/**
 * ********
 * Create kernel sub directories path
 */
$kernel->createConstantFromArray(
    $constant->name('config')->value('config'),
    $constant->name('extra')->value('extra'),
    $constant->name('services')->value('services'),
    $constant->name('konsole')->value('console'),
    $constant->name('extension')->value('extensions')
);

/**
 * ********
 * Create database config base path
 */
$base->fromConstant($constant->name('database')->value('Database'));


/**
 * ********
 * Create utility path
 */
$utility = $kernel->fromConstant($constant->name('utility')->value('utility'));

/**
 * ********
 * Create utility sub directories path
 */
$utility->createConstantFromArray(
    $constant->name('plugin')->value('Plugins'),
    $constant->name('middleware')->value('Middlewares'),
    $constant->name('console')->value('Console'),
    $constant->name('guards')->value('Guards'),
    $constant->name('event')->value('Events')
);

// clean up
$prefix = null;
$constant = null;