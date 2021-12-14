<?php
namespace Http;
use Closure;
/**
 * @package Http Response class
 * @author Amadi ifeanyi
 */
class Response
{
    /**
     * @var bool $resolved 
     */
    private static $resolved = false;

    /**
     * @var mixed $data
     */
    private static $data = [];

    /**
     * @method Response resolve
     * @param int $responseCode
     * @param mixed $data
     * @return void
     */
    public static function resolve(int $responseCode, $data) : void 
    {
        if (self::$resolved === false) :

            // clean buffer
            ob_clean();
            
            // @var string $output
            $output = '';

            // resolve response code
            http_response_code($responseCode);

            // check for string
            if (is_string($data)) :

                // check for xml data
                if (preg_match('/[<][\/](.*?)[>]/', $data)) :

                    // change the content type
                    header('Content-Type: application/xml');

                    // check for xml starting tag
                    if (strpos($data, '<?xml') !== false) :

                        // print xml data
                        $output = $data;

                    else:

                        // build xml data
                        $output = '<?xml version="1.0"?>
                        <response> ' . $data . '</response>';

                    endif;

                else:

                    // change the content type
                    header('Content-Type: application/json');

                    // print json data
                    $output = $data;

                endif;

            elseif (is_array($data)) :

                // get content type
                $usingJson = false;

                // xml
                $usingXml = false;

                // check now 
                $headers = headers_list();

                // check for json or xml
                foreach ($headers as $header) :

                    // convert to lower case
                    $header = strtolower($header);

                    // check for json
                    if (strpos($header, 'application/json') !== false) $usingJson = true;

                    // check for xml
                    if (strpos($header, 'application/xml') !== false) $usingXml = true;

                endforeach;

                // load for json
                if ($usingJson) $output = json_encode($data, JSON_PRETTY_PRINT);

                // load for xml
                if ($usingXml) :

                    // build tag
                    $tags = [];

                    // build tag
                    foreach ($data as $tag => $value) $tags[] = '<'. $tag . '>' . $value . '</' . $tag . '>';

                    // build xml data
                    $output = '<?xml version="1.0"?>
                    <response> ' . implode("\n", $tags) . '</response>';

                endif;

                // use default
                if ($usingXml === false && $usingJson === false) :

                    // change the content type
                    header('Content-Type: application/json');

                    // print json data
                    $output = json_encode($data, JSON_PRETTY_PRINT);

                endif;

            endif;

            // check for output
            if ($output !== '') :

                // render output
                echo $output;

            endif;

            // resolved
            self::$resolved = true;

        endif;

        // return data
        self::$data = $data;
    }

    /**
     * @method Response success
     * @param mixed $data
     */
    public static function success($data)
    {
        // make array
        $data = is_string($data) ? ['message' => $data] : $data;

        // add status
        $data['status'] = 'success';

        // resolve
        self::resolve(200, $data);
    }

    /**
     * @method Response error
     * @param mixed $data
     */
    public static function error($data)
    {
        // make array
        $data = is_string($data) ? ['message' => $data] : $data;

        // add status
        $data['status'] = 'error';

        // resolve
        self::resolve(200, $data);
    }

    /**
     * @method Response warning
     * @param mixed $data
     */
    public static function warning($data)
    {
        // make array
        $data = is_string($data) ? ['message' => $data] : $data;
        
        // add status
        $data['status'] = 'warning';

        // resolve
        self::resolve(200, $data);
    }

    /**
     * @method Response callback
     * @param Closure $callback
     * @return mixed
     */
    public static function callback(Closure $callback)
    {
        // reset 
        self::$data = [];

        // resolve
        self::$resolved = true;

        // get data
        $return = call_user_func($callback);

        // resolve
        self::$resolved = false;

        // return data
        return (count(self::$data) == 0) ? $return : self::$data;
    }
}