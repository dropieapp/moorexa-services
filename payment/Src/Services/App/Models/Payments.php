<?php
namespace Moorexa\Framework\App\Models;

use Closure;
use Src\Package\{
    MVC\Model, Interfaces\ModelInterface
};
use function Lightroom\Database\Functions\{map, db};
/**
 * Payments model class auto generated.
 *
 *@package App Payments Model
 *@author Amadi Ifeanyi <amadiify.com>
 **/

class Payments extends Model
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

    /**
     * @method Payments paymentCompleted
     * @param array $data 
     * @return void
     */
    public function paymentCompleted(array $data)
    {
        // ensure reference doesn't exists
        if (db('payments')->get('reference = ?', $data['reference'])->go()->rowCount() == 0) return db('payments')->insert($data)->go();
    }
}