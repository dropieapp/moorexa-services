<?php

/**
 * @package Database Table Account_services
 * @author Amadi ifeanyi <amadiify.com>
 * 
 * This class provides an handler for Database table Account_services, it can work with any database system,
 * it creates a table, drops a table, alters a table structure and does more. 
 * with the assist manager you can run migration and do more with this package.
 */
class Account_services
{
    // connection identifier
    public $connectionIdentifier = '';


    // create table structure
    public function up($schema)
    {
        $schema->increment('account_serviceid');
        $schema->string('service_name');
        // and more.. 
    }

    // drop table
    public function down($drop, $record)
    {
        // $record carries table rows if exists.
        // execute drop table command
        $drop();
    }

    // options
    public function option($option)
    {
        $option->rename('account_services'); // rename table
        $option->engine('innoDB'); // set table engine
        $option->collation('utf8_general_ci'); // set collation
    }

    // promise during migration
    public function promise($status, $database)
    {
        if ($status == 'complete')
        {
            // add services
            $services = [
                ['service_name' => 'downline alert'],
                ['service_name' => 'login alert'],
                ['service_name' => 'pickup alert'],
                ['service_name' => 'withdraw alert'],
                ['service_name' => 'funding alert'],
                ['service_name' => 'credit alert'],
                ['service_name' => 'delivery alert'],
            ];

            // run services
            foreach ($services as $service) $database->insert($service);
        }
    }
}