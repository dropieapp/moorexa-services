<?php

/**
 * @package Database Table Wallet_status
 * @author Amadi ifeanyi <amadiify.com>
 * 
 * This class provides an handler for Database table Wallet_status, it can work with any database system,
 * it creates a table, drops a table, alters a table structure and does more. 
 * with the assist manager you can run migration and do more with this package.
 */
class Wallet_status
{
    // connection identifier
    public $connectionIdentifier = '';


    // create table structure
    public function up($schema)
    {
        $schema->increment('statusid');
        $schema->string('status');
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
        $option->rename('wallet_status'); // rename table
        $option->engine('innoDB'); // set table engine
        $option->collation('utf8_general_ci'); // set collation
    }

    // promise during migration
    public function promise($status, $database)
    {
        if ($status == 'complete')
        {
            $data = [
                ['status' => 'pending'],
                ['status' => 'processing'],
                ['status' => 'complete'],
                ['status' => 'canceled'],
                ['status' => 'failed']
            ];

            // add status
            foreach ($data as $record) $database->insert($record);
        }
    }
}