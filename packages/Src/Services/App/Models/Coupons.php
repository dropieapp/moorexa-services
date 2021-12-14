<?php
namespace Moorexa\Framework\App\Models;

use Closure;
use Src\Package\{
    MVC\Model, Interfaces\ModelInterface
};
/**
 * Coupons model class auto generated.
 *
 *@package App Coupons Model
 *@author Amadi Ifeanyi <amadiify.com>
 **/

class Coupons extends Model
{
    use \LightQuery;

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
     * @method Coupons getDiscount
     * @param int $coupon_code
     * @return void
     */
    public function getDiscount(int $coupon_code, float $cost)
    {
        // set database table
        $this->setTable('coupon_codes');

        // check for coupon
        $coupon = $this->all('coupon_code = ? and isavaliable = ?', $coupon_code, 1);

        // are we good
        if ($coupon->rowCount() == 0) return app('response')->error([
            'discount' => 0,
            'cost' => $cost
        ]);

        // get the discount
        $discount = intval($coupon->fetch(FETCH_OBJ)->discount);

        // percentage
        $percentage = ($cost * $discount) / 100;

        // get new cost
        app('response')->success([
            'discount' => $discount,
            'cost' => floatval($cost - $percentage)
        ]);
    }
}