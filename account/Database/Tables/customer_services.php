<?php

/**
 * @package Database Table Customer_services
 * @author Amadi ifeanyi <amadiify.com>
 * 
 * This class provides an handler for Database table Customer_services, it can work with any database system,
 * it creates a table, drops a table, alters a table structure and does more. 
 * with the assist manager you can run migration and do more with this package.
 */
class Customer_services
{
    // connection identifier
    public $connectionIdentifier = '';


    // create table structure
    public function up($schema)
    {
        $schema->increment('customer_serviceid');
        $schema->int('customerid');
        $schema->int('serviceid');
        $schema->tinyint('isenabled')->default(1);
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
        $option->rename('customer_services'); // rename table
        $option->engine('innoDB'); // set table engine
        $option->collation('utf8_general_ci'); // set collation
    }

    // promise during migration
    public function promise($status)
    {
        if ($status == 'waiting' || $status == 'complete')
        {
            // do some cool stuffs.
            // $this->table => for ORM operations to this table.
        }
    }
}