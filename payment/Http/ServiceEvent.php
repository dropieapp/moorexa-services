<?php 
namespace Http;

class ServiceEvent
{
    /**
     * @var array $eventPipes
     */
    private static $eventPipes = [];

    /**
     * @var array $eventNames
     */
    private static $eventNames =[

        'login successfull' => [
            'method' => 'POST',
            'endpoint' => 'app/authen-complete',
            'query' => []
        ]
    ];

    /**
     * @method ServiceEvent send
     * @param array $data 
     */
    public static function send(array $data)
    {
        // merge eventpipes
        self::$eventPipes[] = $data;

        // send http header
        header('x-gateway-event-pipe: ' . json_encode(self::$eventPipes));
    }

    /**
     * @method ServiceEvent receive
     * @param array $data
     */
    public static function receive(array $data)
    {
        // get the event
        $event = $data['event'];
        
        // get the data
        $eventData = $data['data'];

        // see if event data is an object
        $eventDataObject = strpos($eventData, '{') !== false ? json_decode($eventData) : null;

        // do we have an object
        if (is_object($eventDataObject)) $eventData = func()->toArray($eventDataObject);

        // can we manage this event
        if (isset(self::$eventNames[$event])) :

            // @var array $eventInfo
            $eventInfo = self::$eventNames[$event];

            // set the request method
            $_SERVER['REQUEST_METHOD'] = strtoupper($eventInfo['method']);

            if (strtoupper($eventInfo['method']) == 'GET') :

                // check for param
                if (isset($eventData['params'])) :
                    $eventInfo['endpoint'] = rtrim($eventInfo['endpoint'], '/') . '/' . $eventData['params'];
                endif;

                // check for query
                if (isset($eventData['query'])) :
                    $eventInfo['query'] = array_merge($eventInfo['query'], $eventData['query']);
                endif;

                // clean data
                $eventData = null;

            endif;

            // set the route
            $_GET['__app_request__'] = $eventInfo['endpoint'];

            // set the data
            if (is_array($eventData)) $_POST = $eventData;

            // append query data
            $_GET = array_merge($_GET, $eventInfo['query']);

        endif;
    }

    /**
     * @method ServiceEvent addJob
     * @param string $service 
     * @param string $event 
     * @param array $data
     */
    public static function addJob(string $service, string $event, array $data)
    {
        \Dispatcher::service('send', [
            'service' => $service,
            'event' => $event,
            'data' => $data
        ]);
    }


    /**
     * @method ServiceEvent runService
     * @param string $service 
     * @param string $event 
     * @param array $data
     */
    public static function runService(string $service, string $event, array $data)
    {
        // use job
        $useJob = true;

        // check headers
        if (function_exists('getallheaders')) :

            // get headeers
            $headers = getallheaders();

            // check if we have x-micro-services
            if (isset($headers['x-micro-services'])) :

                // convert to json object
                $jsonObject = json_decode($headers['x-micro-services']);

                // can we read
                if ($jsonObject !== null) :

                    // run a loop and check for service
                    foreach ($jsonObject as $serviceName => $serviceUrl) :

                        if ($serviceName == $service) :

                            // create an http instance
                            $http = new HttpRequest();

                            // set the http headers
                            HttpRequest::header(['x-service-event' => $event, 'x-service-data' => json_encode($data)]);
                        
                            // send request
                            $request = $http->sendRequest('get', $serviceUrl);

                            // clean up
                            $http = null;

                            // don't add to gateway job
                            $useJob = false;

                            // break out
                            break;

                        endif;

                    endforeach;

                    // sent 
                    return $request;

                endif;

            endif;

        endif;

        // run job instead
        if ($useJob) self::addJob($service, $event, $data);
    }
}