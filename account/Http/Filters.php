<?php
namespace Http;
use function Lightroom\Requests\Functions\{post, get};
/**
 * @package Filters helper
 * @author Amadi Ifeanyi <amadiify.com>
 */
class Filters
{
    /**
     * @method Filters registration
     * @return object
     */
    public static function registration()
    {
        $filter = filter('POST', [
            'firstname' => 'string|required|min:2|notag',
            'lastname' => 'string|required|min:2|notag',
            'phone_number' => 'number|required|min:10|notag',
            'email_address' => 'email|required|min:10',
            'security_question' => 'number|required',
            'security_answer' => 'required|notag',
            'password' => 'required|min:4',
            'password_again' => 'required|min:4'
        ]);

        // check for subscribe
        if (post()->has('subscribe')) $filter->set('subscribe', post()->subscribe);

        // return filter
        return $filter;
    }

    /**
     * @method Filters login
     * @return object
     */
    public static function login(array $postData = [])
    {
        $filter = filter($postData, [
            'username' => 'required|notag|min:2',
            'password' => 'required|min:4'
        ]);

        // return filter
        return $filter;
    }

    /**
     * @method Filters resetPassword
     * @return object
     */
    public static function resetPassword()
    {
        $filter = filter('POST', [
            'username' => 'required|notag|min:4',
            'security_question' => 'required|number',
            'security_answer' => 'required|notag'
        ]);

        // return filter
        return $filter;
    }


    /**
     * @method Filters completeResetPassword
     * @return object
     */
    public static function completeResetPassword()
    {
        $filter = filter('POST', [
            'customerid' => 'required|number|min:1',
            'new_password' => 'required|min:4',
        ]);

        // return filter
        return $filter;
    }
}