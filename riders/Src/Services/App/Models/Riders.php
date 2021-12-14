<?php
namespace Moorexa\Framework\App\Models;

use Closure;
use Src\Package\{
    MVC\Model, Interfaces\ModelInterface
};
use function Lightroom\Database\Functions\{map, db};
/**
 * Riders model class auto generated.
 *
 *@package App Riders Model
 *@author Amadi Ifeanyi <amadiify.com>
 **/

class Riders extends Model
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
     * @method Riders autoGenerateUsername
     * @param string $firstname
     * @param string $lastname
     * @return string
     */
    public function autoGenerateUsername(string $firstname, string $lastname) : string 
    {
        // format firstname and lastname
        $username = strtolower($firstname) . ucfirst($lastname);

        // do we have a record
        $query = map(db('drivers_information')->get('username = ?', $username));

        // can we use this ?
        if ($query->rows == 0) return $username;

        // nope, let's reverse the username
        $username = strtolower($lastname) . ucfirst($firstname);

        // do we have a record
        $query = map(db('drivers_information')->get('username = ?', $username));

        // can we use this ?
        if ($query->rows == 0) return $username;

        // nope let's add the timestamp
        // format firstname and lastname
        $username = strtolower($firstname) . ucfirst($lastname) . time();

        // do we have a record
        $query = map(db('drivers_information')->get('username = ?', $username));

        // can we use this ?
        if ($query->rows == 0) return $username;

        // couldn't proceed
        return '';
    }

    /**
     * @method Riders postAddUsername
     * @return mixed
     */
    public function postAddUsername()
    {
        $input = filter('POST', [
            'customerid' => 'required|number',
            'username' => 'required|string|min:1|notag'
        ]);

        // are we good
        if (!$input->isOk()) return app('response')->error('You have an invalid POST data');

        // let's check the customerid
        if (db('drivers_information')->get('customerid = ?', $input->customerid)->go()->rowCount() == 0) return app('response')->error('Unkown Rider. Account does not exists.');

        // check username
        $query = map(db('drivers_information')->get('username = ?', $input->username));

        // do we have any
        if ($query->rows > 0) return app('response')->error('Username already in use');

        // else we can add for customer
        db('drivers_information')->update(['username' => $input->username], 'customerid = ?', $input->customerid)->go();

        // add now
        app('response')->success('Username for profile added successfully.');
    }
}