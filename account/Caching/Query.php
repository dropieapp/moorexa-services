<?php
namespace Caching;

use function Lightroom\Database\Functions\{map, db};
/**
 * @method Caching Query
 * @author Amadi Ifeanyi <amadiify.com>
 */
class Query
{
    public static function fetch(string $table, $object = null, $callback = null)
    {
        // load callback
        if ($object !== null && is_callable($object)) $callback = $object;

        // load query
        $query = db($table)->get();

        // load object
        if (is_object($object)) :

            // check for query_$table
            if (method_exists($object, 'query_' . $table)) :

                $method = 'query_' . $table;

                // load query method
                $object->{$method}($query);

            endif;

        endif;

        // get the query
        $sql = $query->query;

        // get the bind
        $bind = md5(serialize($query->bind));

        // execute query
        $result = map($query);

        // response object
        $response = [];

        // pull down
        $result->obj(function($row) use (&$response, &$callback){
            $response[$row->primary()] = is_callable($callback) ? call_user_func($callback, $row) : $row;
        });

        // return response
        return $response;
    }
}