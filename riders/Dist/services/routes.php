<?php

use Src\Package\Router as Route;
use function Lightroom\Database\Functions\{map, db};
/*
 ***************************
 * 
 * @ Route
 * info: Add your GET, POST, DELETE, PUT request handlers here. 
*/


// get rider current position
Route::get('get-rider-current-position/{riderid}', function($riderid){

    // validate the input
    $input = filter(['riderid' => $riderid], [
        'riderid' => 'required|number'
    ]);

    // are we good ?
    if (!$input->isOk()) return app('response')->error('Invalid riderid. Request canceled.');

    // check for account
    $account = map(db('drivers_information')->get('customerid = ?', $input->riderid));

    // all good ?
    if ($account->rows == 0) return app('response')->error('Invalid riderid. Account does not exists.');

    //return location
    app('response')->success([
        'latitude' => $account->current_latitude,
        'longitude' => $account->current_longitude
    ]);
    
}); 