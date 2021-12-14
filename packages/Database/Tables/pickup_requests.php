<?php

/**
 * @package Database Table Pickup_requests
 * @author Amadi ifeanyi <amadiify.com>
 * 
 * This class provides an handler for Database table Pickup_requests, it can work with any database system,
 * it creates a table, drops a table, alters a table structure and does more. 
 * with the assist manager you can run migration and do more with this package.
 */
class Pickup_requests
{
    // connection identifier
    public $connectionIdentifier = '';


    // create table structure
    public function up($schema)
    {
        $schema->increment('requestid');
        $schema->bigint('customerid')->default(0);
        $schema->bigint('riderid');
        $schema->float('amount');
        $schema->string('sender_firstname');
        $schema->string('sender_lastname');
        $schema->string('sender_telephone');
        $schema->string('reciever_firstname');
        $schema->string('reciever_lastname');
        $schema->string('reciever_telephone');
        $schema->int('delivery_methodid');
        $schema->int('rateid');
        $schema->string('pickup_address', 300);
        $schema->string('pickup_coordinates');
        $schema->string('dropoff_address', 300);
        $schema->string('dropoff_coordinates');
        $schema->string('coupon_code');
        $schema->text('package_hint');
        $schema->int('package_quantity')->default(1);
        $schema->string('dateadded');
        $schema->float('extra_tip')->default(0);
        $schema->int('completed')->default(0);
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
        $option->rename('pickup_requests'); // rename table
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