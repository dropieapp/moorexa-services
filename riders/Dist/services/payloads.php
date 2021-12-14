<?php
use function Lightroom\Functions\GlobalVariables\var_set;
/**
 * @package Payloads Registry. 
 * @author Amadi Ifeanyi <amadiify.com>
 * 
 * This file gives you the ability to add payloads to the controller stack. If you choosed Moorexa MVC, this file
 * would be called after the middleware payload has been attached.
 * 
 * Here you have access to $payload variable, $incomingUrl and the Controller ViewHandler class itself with $this
 */

 // export incomingurl
 var_set('incoming-url', $incomingUrl);
