<?php

/**
 * @package Database Table Security_questions
 * @author Amadi ifeanyi <amadiify.com>
 * 
 * This class provides an handler for Database table Security_questions, it can work with any database system,
 * it creates a table, drops a table, alters a table structure and does more. 
 * with the assist manager you can run migration and do more with this package.
 */
class Security_questions
{
    // connection identifier
    public $connectionIdentifier = '';


    // create table structure
    public function up($schema)
    {
        $schema->increment('security_questionid');
        $schema->string('security_question');
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
        $option->rename('security_questions'); // rename table
        $option->engine('innoDB'); // set table engine
        $option->collation('utf8_general_ci'); // set collation
    }

    // promise during migration
    public function promise($status, $database)
    {
        if ($status == 'complete')
        {
            $records = [
                [
                    'security_question' => 'What is your pet name?'
                ],
                [
                    'security_question' => 'What is your favorite country?'
                ],
                [
                    'security_question' => 'What is your favorite car?'
                ],
                [
                    'security_question' => 'What would you do if given 100 million dollars?'
                ],
                [
                    'security_question' => 'Where do you see yourself in 5 - 10 years from now?'
                ],
            ];

            // insert now
            foreach ($records as $record) $database->insert($record);
        }
    }
}