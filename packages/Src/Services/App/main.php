<?php
namespace Moorexa\Framework;

use Src\Package\MVC\Controller;
use Container\HttpResponse;
use function Lightroom\Database\Functions\{map, db};
use Moorexa\Framework\App\Models\Coupons;
use Lightroom\Adapter\ClassManager;
/**
 * Documentation for App Page can be found in App/readme.txt
 *
 *@package      App Page
 *@author       Moorexa <www.moorexa.com>
 *@author       Amadi Ifeanyi <amadiify.com>
 **/

class App extends Controller
{
    /**
    * @method App home
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/

    public function home() : void 
    {
        // dispatch event
        app('service')->addJob('service', 'event name', ['data' => 'value']);

        HttpResponse::resolve(200, ['status' => 'success']);
    }

    /**
    * @method App all
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function all()
    {
        
    }

    /**
    * @method App todayRates
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function todayRates() : void
    {
        
    }

    /**
    * @method App riderPickups
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function riderPickups(App\Providers\RiderPickupsProvider $provider) : void
    {
        
    }

    /**
    * @method App requestPickup
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return mixed
    **/
    public function requestPickup()
    {
        
    }

    /**
    * @method App calculatePrice
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return mixed
    **/
    public function calculatePrice()
    {
        $input = filter('POST', [
            'geo_location' => 'notag|required|string',
            'dropoff_geo_location' => 'notag|required|string',
            'delivery_methodid' => 'number|required',
            'coupon_code' => 'notag',
            'tip_amount' => ['notag', 0]
        ]);

        // are we good ?
        if (!$input->isOk()) return app('response')->error('You have an error in your post data');

        // manage geo location
        $input->geo_location = html_entity_decode($input->geo_location, ENT_QUOTES, 'UTF-8');

        // manage dropoff geo_location
        $input->dropoff_geo_location = html_entity_decode($input->dropoff_geo_location, ENT_QUOTES, 'UTF-8');

        // get the geo location object
        $geo_location = json_decode($input->geo_location);
        $dropoff_geo_location = json_decode($input->dropoff_geo_location);

        // check geo location
        if (!is_object($geo_location)) return app('response')->error('Your Geo Location must be an object');

        // check dropoff geo_location
        if (!is_object($dropoff_geo_location)) return app('response')->error('Your Dropoff Geo Location must be an object');

        // get pickup latitude and longtitude
        $pickup = $geo_location->latitude . ',' . $geo_location->longitude;

        // get dropoff latitude and longtitude
        $dropoff = $dropoff_geo_location->latitude . ',' . $dropoff_geo_location->longitude;

        // fetch the mile
        $response = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins='.($pickup).'&destinations='.$dropoff.'&language=en-us&units=imperial&key=AIzaSyBaXGkaN8bhDj5rWTnWUDV6gwOWNPB9JLM');

        // get the json data
        $json = json_decode($response);

        // get the distance
        $distance = floatval(preg_replace('/[a-zA-Z\s]/', '', $json->rows[0]->elements[0]->distance->text));

        // get today rates
        $todayRates = app('response')->callback(function(){
            $this->model->getTodayRates();
        });

        // get the base fare
        $fare = map(db('delivery_methods')->get('delivery_methodid = ?', $input->delivery_methodid));

        // calculate cost
        $cost = floatval($fare->delivery_base_fare) + (floatval($todayRates['rate']) * $distance);

        // find discount
        $cost = app('response')->callback(function() use ($cost, $input){
            // find discount with coupon code
            ClassManager::singleton(Coupons::class)->getDiscount($input->coupon_code, $cost);
        })['cost'];

        // add the tip amount
        $cost += floatval($input->tip_amount);

        // so let's return the price
        app('response')->success([
            'price' => $cost,
            'currency' => 'NGN'
        ]);
    }

    /**
    * @method App discount
    *
    * See documentation https://www.moorexa.com/doc/controller
    *
    * You can catch params sent through the $_GET request
    * @return void
    **/
    public function discount(Coupons $model) : void
    {
        
    }
}
// END class