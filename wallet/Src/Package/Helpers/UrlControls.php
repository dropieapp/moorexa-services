<?php
namespace Src\Package\Helpers;

use function Lightroom\Requests\Functions\get;
use Src\Package\Router;
/**
 * @package UrlControls
 * @author Amadi Ifeanyi <amadiify.com>
 * 
 */
class UrlControls
{
    use RouterControls;

    // process url
	public static function getUrl() : array
	{
        // @var array $requestDecoded
        $requestDecoded = [];

		// get target
        $target = self::loadConfig()['beautiful_url_target'];

        // do we have a path request
        // check if target doesn't exist
        if (!get()->has($target)) :

            // check REQUEST_URI from server
            if (isset($_SERVER['REQUEST_URI'])) :

                // get the request url
                $requesturl = $_SERVER['REQUEST_URI'];

                // get parsed url
                $parsedUrl = parse_url($requesturl);

                if (isset($parsedUrl['path'])) :

                    // remove the leading /
                    $requesturl = ltrim($parsedUrl['path'], '/');

                    // get the script name
                    $scriptName = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : null;

                    if ($scriptName !== null) :

                        // check and be sure that request url is not a path
                        if (strpos($scriptName, '/' . $requesturl) !== false) $requesturl = '';

                    endif;

                    // add to get request
                    $_GET[$target] = $requesturl;

                endif;
                
            endif;

        endif;
        
        // check if $_GET has $target
        if (is_string($target) && get()->has($target)) :

            // get request
            $request = get()->get($target);

            // request decoded
            $requestDecoded = explode('/', rtrim(get()->decode($request), '/'));

            // just a fallback. in case something went wrong with the .htaccess config
            $parsedUrl = parse_url($request);

            // check if scheme exists
            if (isset($parsedUrl['scheme']) && isset($parsedUrl['path'])) :

                // request decoded
                $requestDecoded = explode('/', rtrim(get()->decode($parsedUrl['path']), '/'));

            endif;

            // reset to default controller if requestDecoded[0] is empty
            $requestDecoded[0] = empty($requestDecoded[0]) ? Router::readConfig('router.default.controller') : $requestDecoded[0];

        endif;

        // return array
		return $requestDecoded;
    }
    
    // clean url
	public static function cleanUrl(...$arguments) : array
	{
        // update arguments
        if (count($arguments) > 0 && is_array($arguments[0])) $arguments = $arguments[0];
        
		// get data
		foreach ($arguments as $index => $argument) :
	
			// ensure index value doesn't have space but does contain -
			if (!preg_match('/\s+/', $argument) && preg_match('/[-]/', $argument)) :
			
				//ok ok.. so let's be happy
				$argument = lcfirst(preg_replace('/\s+/','', ucwords(preg_replace('/[-]/',' ', trim(preg_replace("/[^a-zA-Z0-9\s_-]/",'', $argument))))));
                // all done!
                
            endif;
			
            $arguments[$index] = $argument;
            
        endforeach;

        // return array
		return $arguments;
	}
}