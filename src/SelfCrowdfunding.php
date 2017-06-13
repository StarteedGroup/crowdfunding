<?php

namespace Starteed;

use Http\Client\Exception\HttpException;
use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Starteed\Responses\JWTResponse;
use Starteed\Events\BlacklistedEvent;
use Psr\Http\Message\RequestInterface;
use Starteed\Responses\StarteedResponse;
use Starteed\Exceptions\StarteedException;
use Http\Discovery\MessageFactoryDiscovery;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Starteed Self Crowdfunding
 *
 * Class that handles all the requests and the basic endpoints to access data
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class SelfCrowdfunding
{   
    /**
     * Library version, used for setting User-Agent
     *
     * @var string
     */
    protected $version = '0.1';

    /**
     * HTTP client used to make requests
     *
     * @var \Http\Client\HttpClient
     */
    protected $httpClient;

    /**
     * The chosen message factory
     *
     * @var \Http\Message\RequestFactory
     */
    protected $messageFactory;

    /**
     * JWT token used as authentication bearer
     *
     * @var string
     */
    protected static $token;

    /**
     * Options for requests
     *
     * @var array
     */
    protected $options;

    /**
     * Default options for requests that can be overridden with the setOptions function.
     *
     * @var array
     */
    protected static $defaultOptions = [
        'host' => 'api.starteed.com',
        'protocol' => 'https',
        'port' => 443,
        'key' => '',
        'version' => 'v1',
        'language' => 'it_IT',
        'authorization' => null,
        'platform' => null
    ];

    /**
     * Instance of Platform class
     *
     * @var PlatformEndpoint
     */
    public $platform;

    /**
     * Instance of General class
     *
     * @var General
     */
    public $general;

    /**
     * Instance of Layout class
     *
     * @var General
     */
    public $layout;

    /**
     * Instance of Version class
     *
     * @var Version
     */
    public $versions;

    /**
     * Instance of Section class
     *
     * @var Version
     */
    public $sections;

    /**
     * Instance of Campaign class
     *
     * @var Campaign
     */
    public $campaigns;

    /**
     * The event dispatcher of Starteed Self
     *
     * @var EventDispatcher
     */
    public static $dispatcher;

    /**
     * Sets up the Self instance.
     *
     * @param HttpClient $http_client - An httplug client or adapter
     * @param array      $options     - An array to overide default options
     */
    public function __construct(HttpClient $http_client, array $options)
    {
        $this->setOptions($options);
        $this->setHttpClient($http_client);
        $this->setupEndpoints();
    }

    /**
     * Wrapper for Symfony EventDispatcher
     *
     * @param string $name  The event name
     * @param Event  $event Interface of Event
     *
     * @return \Symfony\Component\EventDispatcher\Event
     */
    public static function dispatch($name, Event $event)
    {
        return static::getDispatcher()->dispatch($name, $event);
    }

    /**
     * Getter for Singleton for Event Dispatcher
     *
     * @return EventDispatcher
     */
    public static function getDispatcher()
    {
        if (!static::$dispatcher) {
            static::$dispatcher = new EventDispatcher();

        }
        return static::$dispatcher;
    }

    /**
     * Sends sync request.
     * The first try/catch block detect if the exception is a Token blacklisting: in this case the event
     * BlacklistedEvent id dispatched in order to provide a convenient way to refresh the token with a brand new and
     * repeat the original request.
     * The last try/catch block returns the StarteedResponse or throws any kind of exception to avoid a infinite loop.
     *
     * @param string $method  The request method (GET|POST|PUT|PATCH|DELETE)
     * @param string $uri     The URI of endpoint
     * @param array  $payload Either used as the request body or URL query params
     * @param array  $headers Additional headers to send along with request
     *
     * @return \Starteed\Responses\StarteedResponse Response due to sync request
     *
     * @throws \Starteed\Exceptions\StarteedException Exception if token has been blacklisted or something goes wrong
     */
    public function request($method = 'GET', $uri = '', $payload = [], $headers = [])
    {
        try {
            $request = $this->buildRequest($method, $uri, $payload, $headers);
            return new StarteedResponse($this->httpClient->sendRequest($request));
        } catch (HttpException $exception) {
            $exception = new StarteedException($exception);
            if ($exception->getMessage() === 'The token has been blacklisted') {
                static::dispatch(BlacklistedEvent::NAME, new BlacklistedEvent($this, $request));
            } else {
                throw $exception;
            }
        }
        try {
            $request = $this->buildRequest($method, $uri, $payload, $headers);
            return new StarteedResponse($this->httpClient->sendRequest($request));
        } catch (HttpException $e) {
            throw new StarteedException($e);
        }
    }

    /**
     * Builds request from given params.
     *
     * @param string $method  The request method (GET|POST|PUT|PATCH|DELETE)
     * @param string $uri     The URI of request
     * @param array  $payload Either used as the request body or URL query params
     * @param array  $headers Additional headers to send along with request
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function buildRequest($method, $uri, $payload, $headers)
    {
        $method = trim(strtoupper($method));
        if ($method === 'GET') {
            $params = $payload;
            $body = [];

        } else {
            $params = [];
            $body = $payload;

        }
        $url = $this->getUrl($uri, $params);
        $headers = $this->getHttpHeaders($headers);
        /*
         * Starteed Self API will not tolerate form feed in JSON.
         */
        $jsonReplace = [
            '\f' => '',
        ];
        $body = strtr(json_encode($body), $jsonReplace);
        return $this->getMessageFactory()->createRequest($method, $url, $headers, $body);
    }

    /**
     * Returns an array for the request headers.
     *
     * @param array $headers Custom headers for the request
     *
     * @return array $headers Headers for the Request
     */
    public function getHttpHeaders($headers = [])
    {
        $constantHeaders = [
            'User-Agent' => 'php-starteed-crowdfunding/'.$this->version,
            'Content-Type' => 'application/json',
            'Accept-Language' => $this->options['language'],
            'X-Platform' => $this->options['platform'],
        ];
        if (static::getAuthToken()) {
            $constantHeaders['Authorization'] = 'Bearer ' . static::getAuthToken();

        }
        foreach ($constantHeaders as $key => $value) {
            $headers[$key] = $value;

        }
        return $headers;
    }

    /**
     * Builds the request url from the options and given params.
     *
     * @param string $path   - the path in the url to hit
     * @param array  $params - query parameters to be encoded into the url
     *
     * @return string $url - the url to send the desired request to
     */
    public function getUrl($path, $params = [])
    {
        $options = $this->options;
        $paramsArray = [];
        foreach ($params as $key => $value) {
            if ($key == 'where' && is_array($value)) {
                foreach ($value as $where => $value) {
                    if ( is_array($value) ) {
                        array_push(
                            $paramsArray,
                            $key . '[' . $where . '][operator]' . '=' . $value['operator']
                        );
                        array_push(
                            $paramsArray,
                            $key . '[' . $where . '][value]' . '=' . $value['value']
                        );

                    } else {
                        array_push($paramsArray, $key.'['.$where.']'.'='.$value);

                    }
                }

            } else {
                array_push($paramsArray, $key.'='.$value);

            }

        }
        $paramsString = implode('&', $paramsArray);
        return $options['protocol'].'://'.$options['host'].($options['port'] ? ':'.$options['port'] : '').'/'.$options['version'].'/'.$path.($paramsString ? '?'.$paramsString : '');
    }

    /**
     * Sets $http_client to be used for request
     *
     * @param \Http\Client\HttpClient $httpClient The client to be used for request
     *
     * @return void
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Sets the options from the param and defaults for the Starteed Self object
     *
     * @param array $options Array of options: platform hostname is mandatory
     *
     * @return void
     */
    public function setOptions(array $options)
    {
        $this->options = isset($this->options) ? $this->options : static::$defaultOptions;
        // set options, overriding defaults
        foreach ($options as $option => $value) {
            if (key_exists($option, $this->options)) {
                $this->options[$option] = $value;
            }
        }
    }

    /**
     * Set up endpoints for tree traversing.
     *
     * @return void
     */
    protected function setupEndpoints()
    {
        $this->platform = new PlatformEndpoint($this);
        $this->campaigns = new CampaignsEndpoint($this);
        $this->general = new GeneralEndpoint($this);



        $this->layout = new Layout($this);
        $this->versions = new Version($this);
        $this->sections = new Section($this);
    }

    /**
     * Return discovered and available Message Factory
     *
     * @return \Http\Message\RequestFactory
     */
    protected function getMessageFactory()
    {
        if (!$this->messageFactory) {
            $this->messageFactory = MessageFactoryDiscovery::find();

        }
        return $this->messageFactory;
    }

    /**
     * Enable override of Message Factory
     *
     * @param \Http\Message\RequestFactory $messageFactory The choosen message factory
     *
     * @return \Starteed\SelfCrowdfunding
     */
    public function setMessageFactory(RequestFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
        return $this;
    }

    /**
     * Execute login via a provided key to obtain the JWT.
     *
     * @param string $key API key
     *
     * @return \Starteed\Responses\JWTResponse Response wrapper for the JSON Web Token
     *
     * @throws \Starteed\Exceptions\StarteedException
     */
    public function login($key)
    {
        try {
            $request = $this->buildRequest('POST', 'login', ['key' => $key], []);
            $response = new JWTResponse( $this->httpClient->sendRequest($request) );
            static::setAuthToken( $response->getBody()['token'] );
            return $response;
        } catch (\Exception $exception) {
            throw new StarteedException($exception);
        }
    }

    /**
     * Token getter
     *
     * @return string|null The JSON Web Token
     */
    public static function getAuthToken()
    {
        if (static::$token) {
            return static::$token;
        }
    }

    /**
     * Token setter
     *
     * @param string $jwt The JSON Web Token obtained via login or refresh
     */
    public static function setAuthToken($jwt)
    {
        static::$token = $jwt;
    }
}
