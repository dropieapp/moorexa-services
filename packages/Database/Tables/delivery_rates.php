<?php

/**
 * @package Database Table Delivery_rates
 * @author Amadi ifeanyi <amadiify.com>
 * 
 * This class provides an handler for Database table Delivery_rates, it can work with any database system,
 * it creates a table, drops a table, alters a table structure and does more. 
 * with the assist manager you can run migration and do more with this package.
 */
class Delivery_rates
{
    // connection identifier
    public $connectionIdentifier = '';


    // create table structure
    public function up($schema)
    {
        $schema->increment('rateid');
        $schema->string('current_day');
        $schema->string('from_5_7_am');
        $schema->string('from_7_12_pm');
        $schema->string('from_12_4_pm');
        $schema->string('from_4_7_pm');
        $schema->string('from_7_10_pm');

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
        $option->rename('delivery_rates'); // rename table
        $option->engine('innoDB'); // set table engine
        $option->collation('utf8_general_ci'); // set collation
    }

    // promise during migration
    public function promise($status, $database)
    {
        if ($status == 'complete')
        {
            for ($x = 0; $x <= 7; $x++) :

                // insert rates
                $database->insert([
                    'current_day' => date('Y-m-d', strtotime('+' . $x . ' day')),
                    'from_5_7_am' => 80,
                    'from_7_12_pm' => 75,
                    'from_12_4_pm' => 70,
                    'from_4_7_pm' => 75,
                    'from_7_10_pm' => 80,
                ]);

            endfor;
        }
    }
}