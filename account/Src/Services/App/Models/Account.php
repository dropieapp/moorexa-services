<?php
namespace Moorexa\Framework\App\Models;

use Closure;
use Src\Package\{
    MVC\Model, Interfaces\ModelInterface
};
use function Lightroom\Database\Functions\{db, map};
/**
 * Account model class auto generated.
 *
 *@package App Account Model
 *@author Amadi Ifeanyi <amadiify.com>
 **/

class Account extends Model
{
    /**
     * @method ModelInterface onModelInit
     * @param ModelInterface $model
     * @param Closure $next
     * @return void
     */
    public function onModelInit(ModelInterface $model, Closure $next) : void 
    {
        // call closure
        $next();
    }

    public function getAccount(int $customerid)
    {
        // get customer account info
        $customer = map(db('customers')->get('customerid = ?', $customerid));

        // do we have a record
        if ($customer->rows > 0) :

            // return account information
            app('response')->success([
                'account' => $customer->row()
            ]);
            
        endif;

        // no record found
        app('response')->error('No Customer record found.');
    }
}