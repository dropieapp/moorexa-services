<?php
namespace Database\Helpers;

use function Lightroom\Database\Functions\{map, db};
/**
 * @package Database Services
 * @author Amadi Ifeanyi <amadiify.com>
 */
class Services
{

    /**
     * @method Services disable
     * @param int $customerid
     * @param int $serviceid
     * @return bool
     * 
     * disables a service for a customer
     */
    public static function disable(int $customerid, int $serviceid)
    {
        // @var bool $disabled
        $disabled = false;

        // check for customer
        $service = map(db('customer_services')->get('customerid = ? and serviceid = ?', $customerid, $serviceid));

        // do we have this service
        if ($service->rows > 0) :

            $service->update([
                'isenabled' => 0
            ]);

            // disabled
            $disabled = true;
            
        endif;

        // disabled
        return $disabled;
    }

    /**
     * @method Services enable
     * @param int $customerid
     * @param int $serviceid
     * @return bool
     * 
     * enable a service for a customer
     */
    public static function enable(int $customerid, int $serviceid) : bool
    {
        // @var bool $enabled
        $enabled = false;

        // check for customer
        $service = map(db('customer_services')->get('customerid = ? and serviceid = ?', $customerid, $serviceid));

        // do we have this service
        if ($service->rows > 0) :

            $service->update([
                'isenabled' => 1
            ]);

            // enabled
            $enabled = true;

        endif;

        // enabled
        return $enabled;
    }

    /**
     * @method Services enabled
     * @param int $customerid
     * @param string $service_name
     * @return bool
     * 
     * Checks if a service is enabled for a customer
     */
    public static function enabled(int $customerid, string $service_name) : bool 
    {
        // is enabled
        $enabled = false;

        // get service
        $service = map(db('account_services')->get('service_name = ?', $service_name));

        // check row
        if ($service->rows > 0) :

            // check for customer
            $service = map(db('customer_services')->get('customerid = ? and serviceid = ?', $customerid, $service->account_serviceid));

            // are we good
            if ($service->rows > 0 && $service->isenabled == 1) $enabled = true;

        endif;

        // return bool
        return $enabled;
    }
}