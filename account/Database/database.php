<?php

use Lightroom\Database\ConnectionSettings as Connection;

/**
 * Database connection settings
 *
 * @return array
 * @author Moorexa <www.moorexa.com> 
 * @author Amadi Ifeanyi <amadiify.com>
 * 
 * This Returns a set of database configurations and a default connection settings.
 **/
Connection::load([

	//enable access from PHP to MYSQL database.
	'new-db' => [
		'dsn' 		=> '{driver}:host={host};dbname={dbname};charset={charset}',
		'driver'    => Lightroom\Database\Drivers\Mysql\Driver::class,
		'host' 	    => '',
		'user'      => '',
		'pass'  	=> '',
		'dbname'    => '',
		'charset'   => 'utf8mb4',
		'port'      => '',
		'attributes'=> true,
		'prefix'	=> '',
		'production'=> [
			'driver'  =>   Lightroom\Database\Drivers\Mysql\Driver::class,
			'host'    =>   '',
			'user'    =>   '',
			'pass'    =>   '',
			'dbname'  =>   '',
		],
		'dev' => [
			'host' => 'localhost',
			'user' => 'root',
			'dbname' => 'dropexpress_accounts',
			'pass' => 'root'
		],
		'session-db' => [
			'host' => 'localhost',
			'user' => 'root',
			'dbname' => 'dropexpress_sessiondb',
			'pass' => 'root'
		]
	],

// choose from any of your configuration for a default connection
])
->default(['development' => 'new-db@dev', 'live' => '']);

