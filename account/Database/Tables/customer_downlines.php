<?php

/**
 * @package Database Table Customer_downlines
 * @author Amadi ifeanyi <amadiify.com>
 * 
 * This class provides an handler for Database table Customer_downlines, it can work with any database system,
 * it creates a table, drops a table, alters a table structure and does more. 
 * with the assist manager you can run migration and do more with this package.
 */
class Customer_downlines
{
    // connection identifier
    public $connectionIdentifier = '';


    // create table structure
    public function up($schema)
    {
        $schema->increment('customer_downlineid');
        $schema->bigint('customerid');
        $schema->bigint('downlineid');
        $schema->int('transactions')->default(0);
        $schema->float('bonus_earned')->default(0);
        $schema->string('time_registered');
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
        $option->rename('customer_downlines'); // rename table
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