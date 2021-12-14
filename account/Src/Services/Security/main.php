<?php
namespace Moorexa\Framework;

use Src\Package\MVC\Controller;
/**
 * Documentation for Security Page can be found in Security/readme.txt
 *
 *@package      Security Page
 *@author       Moorexa <www.moorexa.com>
 *@author       Amadi Ifeanyi <amadiify.com>
 **/

class Security extends Controller
{
    /**
    * @method Security questions
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function questions() : void 
    {
        // fetch all records
        $records = app('query')->fetch('security_questions', function($row){
            return $row->security_question;
        });

        // all done
        app('response')->resolve(200, ['status' => 'success', 'questions' => $records]);
    }
}