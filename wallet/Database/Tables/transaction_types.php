<?php

/**
 * @package Database Table Transaction_types
 * @author Amadi ifeanyi <amadiify.com>
 * 
 * This class provides an handler for Database table Transaction_types, it can work with any database system,
 * it creates a table, drops a table, alters a table structure and does more. 
 * with the assist manager you can run migration and do more with this package.
 */
class Transaction_types
{
    // connection identifier
    public $connectionIdentifier = '';


    // create table structure
    public function up($schema)
    {
        $schema->increment('transactionTypeid');
        $schema->string('transactionType');
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
        $option->rename('transaction_types'); // rename table
        $option->engine('innoDB'); // set table engine
        $option->collation('utf8_general_ci'); // set collation
    }

    // promise during migration
    public function promise($status, $database)
    {
        if ($status == 'complete')
        {
            $data = [
                ['transactionType' => 'funding'],
                ['transactionType' => 'withdrawal'],
                ['transactionType' => 'bonus'],
                ['transactionType' => 'pickup payment'],
            ];

            // add types
            foreach ($data as $record) $database->insert($record);
        }
    }
}