<?php

/**
 * @package Database Table Delivery_methods
 * @author Amadi ifeanyi <amadiify.com>
 * 
 * This class provides an handler for Database table Delivery_methods, it can work with any database system,
 * it creates a table, drops a table, alters a table structure and does more. 
 * with the assist manager you can run migration and do more with this package.
 */
class Delivery_methods
{
    // connection identifier
    public $connectionIdentifier = '';

    // create table structure
    public function up($schema)
    {
        $schema->increment('delivery_methodid');
        $schema->string('delivery_method');
        $schema->float('delivery_base_fare');
        $schema->string('delivery_white_icon');
        $schema->text('delivery_method_note');
        $schema->tinyint('visible')->default(1);
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
        $option->rename('delivery_methods'); // rename table
        $option->engine('innoDB'); // set table engine
        $option->collation('utf8_general_ci'); // set collation
    }

    // promise during migration
    public function promise($status, $database)
    {
        if ($status == 'complete')
        {
            // generate delivery methods
            $methods = [
                [
                    'delivery_method' => 'Bicycle',
                    'delivery_base_fare' => 150,
                    'delivery_white_icon' => 'bike-white.svg',
                    'delivery_method_note' => ''
                ],
                [
                    'delivery_method' => 'Motocycle',
                    'delivery_base_fare' => 300,
                    'delivery_white_icon' => 'motorcycle-white.svg',
                    'delivery_method_note' => ''
                ],
                [
                    'delivery_method' => 'Tricycle',
                    'delivery_base_fare' => 400,
                    'delivery_white_icon' => 'tricycle.svg',
                    'delivery_method_note' => ''
                ],
                [
                    'delivery_method' => 'Car',
                    'delivery_base_fare' => 500,
                    'delivery_white_icon' => 'car-white.svg',
                    'delivery_method_note' => ''
                ],
                [
                    'delivery_method' => 'Mini Van',
                    'delivery_base_fare' => 700,
                    'delivery_white_icon' => 'mini-van-white.svg',
                    'delivery_method_note' => ''
                ],
                [
                    'delivery_method' => 'Truck',
                    'delivery_base_fare' => 1000,
                    'delivery_white_icon' => 'truck-white.svg',
                    'delivery_method_note' => ''
                ],
                [
                    'delivery_method' => 'Drone',
                    'delivery_base_fare' => 500,
                    'delivery_white_icon' => 'drone-white.svg',
                    'visible' => 0,
                    'delivery_method_note' => ''
                ],
            ];

            // insert all
            foreach ($methods as $method) $database->insert($method);
        }
    }
}