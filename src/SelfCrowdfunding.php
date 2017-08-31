<?php

namespace Starteed;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Starteed\Responses\JWTResponse;
use Starteed\Events\BlacklistedEvent;
use Starteed\Responses\StarteedResponse;
use Starteed\Endpoints\SectionsEndpoint;
use Http\Client\Exception\HttpException;
use Starteed\Endpoints\PlatformEndpoint;
use Starteed\Endpoints\CampaignsEndpoint;
use Starteed\Exceptions\StarteedException;
use Http\Discovery\MessageFactoryDiscovery;
use Starteed\Contracts\SelfCrowdfundingInterface;
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
class SelfCrowdfunding implements SelfCrowdfundingInterface
{   
    /**
     * @var string Library version, used for setting User-Agent
     */
    protected $version = '0.1';

    /**
     * @var \Http\Client\HttpClient HTTP client used to make requests
     */
    protected $httpClient;

    /**
     * @var \Http\Message\RequestFactory The chosen message factory
     */
    protected $messageFactory;

    /**
     * @var string JWT token used as authentication bearer
     */
    protected static $token;

    /**
     * @var array Options for requests
     */
    protected $options;

    /**
     * @var array Default options for requests that can be overridden with the setOptions function.
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
     * @var \Starteed\Endpoints\PlatformEndpoint Instance of Platform class
     */
    protected $platform;

    /**
     * @var \Starteed\Endpoints\SectionsEndpoint Instance of Section class
     */
    protected $sections;

    /**
     * @var \Starteed\Endpoints\CampaignsEndpoint Instance of Campaign class
     */
    protected $campaigns;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface Starteed SELF event dispatcher
     */
    public static $dispatcher;

    /**
     * Sets up the SELF API wrapper instance
     *
     * @param \Http\Client\HttpClient $httpClient HTTP adapter
     * @param array                   $options    Override options
     */
    public function __construct(HttpClient $httpClient, array $options)
    {
        $this->setHttpClient($httpClient);
        $this->setOptions($options);

        $this->platform = new PlatformEndpoint($this);
        $this->campaigns = new CampaignsEndpoint($this);
        $this->sections = new SectionsEndpoint($this);
    }

    /**
     * @return \Starteed\Endpoints\PlatformEndpoint
     */
    public function platform()
    {
        return $this->platform;
    }

    public function campaigns()
    {
        return $this->campaigns;
    }

    /**
     * @return \Starteed\Endpoints\SectionsEndpoint
     */
    public function sections()
    {
        return $this->sections;
    }

    /**
     * Wrapper for event dispatcher
     *
     * @param string                                   $name  Event name
     * @param \Symfony\Component\EventDispatcher\Event $event Interface of Event
     *
     * @return \Symfony\Component\EventDispatcher\Event
     */
    public static function dispatch($name, $event)
    {
        return static::getDispatcher()->dispatch($name, $event);
    }

    /**
     * Singleton getter for event dispatcher
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
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
        $request = $this->buildRequest($method, $uri, $payload, $headers);
        try {
            return new StarteedResponse($this->httpClient->sendRequest($request));
        } catch (HttpException $exception) {
            dd($exception);
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
        } catch (HttpException $exception) {
            throw new StarteedException($exception);
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
    protected function buildRequest($method, $uri, $payload, $headers)
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
        // Starteed SELF API does not tolerate form feed in JSON.
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
    protected function getHttpHeaders($headers = [])
    {
        $constantHeaders = [
            'User-Agent' => "php-starteed-self/{$this->version}",
            'Content-Type' => 'application/json',
            'Accept-Language' => $this->options['language'],
            'X-Platform' => $this->options['platform'],
        ];
        if ($token = $this->getAuthToken()) {
            $constantHeaders['Authorization'] = "Bearer {$token}";
        }
        foreach ($constantHeaders as $key => $value) {
            $headers[$key] = $value;
        }
        return $headers;
    }

    /**
     * Builds the request url from the options and given params.
     *
     * @param string $path   Path URL to hit
     * @param array  $params Query parameters to be encoded
     *
     * @return string $url Composed URL to send the desired request to
     */
    protected function getUrl($path, $params = [])
    {
        $options = $this->options;
        $paramsArray = [];
        foreach ($params as $key => $value) {
            if ($key == 'where' && is_array($value)) {
                foreach ($value as $where => $value) {
                    if (is_array($value)) {
                        array_push(
                            $paramsArray,
                            "{$key}[{$where}][operator]={$value['operator']}"
                        );
                        array_push(
                            $paramsArray,
                            "{$key}[{$where}][value]={$value['value']}"
                        );
                    } else {
                        array_push($paramsArray, "{$key}[{$where}]={$value}");
                    }
                }
            } else {
                array_push($paramsArray, "{$key}={$value}");
            }
        }
        $paramsString = implode('&', $paramsArray);

        return sprintf('%s://%s:%d/%s/%s/%s',
            $options['protocol'],
            $options['host'],
            $options['port'],
            $options['version'],
            $path ?: null,
            $paramsString ? "?{$paramsString}": null
        );
    }

    /**
     * Sets request Http client
     *
     * @param \Http\Client\HttpClient $httpClient Client used for request
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Sets and override default options.
     *
     * @param array $options Array of options: platform hostname is mandatory
     */
    protected function setOptions(array $options)
    {
        $this->options = isset($this->options) ? $this->options : static::$defaultOptions;
        foreach ($options as $option => $value) {
            if (key_exists($option, $this->options)) {
                $this->options[$option] = $value;
            }
        }
    }

    /**
     * Return discovered and available Message Factory
     *
     * @return \Http\Message\RequestFactory
     */
    public function getMessageFactory()
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
     */
    public function setMessageFactory(RequestFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
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
    public function login(string $key)
    {
        try {
            $request = $this->buildRequest('POST', 'login', ['key' => $key], []);
            $response = new JWTResponse( $this->httpClient->sendRequest($request) );
            static::setAuthToken( $response->getBody()['token'] );
            return $response;
        } catch (HttpException $exception) {
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
        return static::$token;
    }

    /**
     * Token setter
     *
     * @param string $jwt The JSON Web Token obtained via login or refresh
     */
    public static function setAuthToken(string $jwt)
    {
        static::$token = $jwt;
    }
}
