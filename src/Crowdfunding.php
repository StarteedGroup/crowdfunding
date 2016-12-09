<?php

namespace Starteed;

use Exception;
use LogicException;
use Http\Client\HttpClient;
use Http\Client\HttpAsyncClient;
use Http\Message\RequestFactory;
use Starteed\Responses\JWTResponse;
use Psr\Http\Message\RequestInterface;
use Starteed\Responses\StarteedResponse;
use Http\Discovery\MessageFactoryDiscovery;
use Starteed\Exceptions\StarteedException;

/**
 * Starteed Crowdfunding
 *
 * Class that handles all the requests and the basic endpoints to access data
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Crowdfunding
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Crowdfunding
{
    /**
     * Library version, used for setting User-Agent
     *
     * @var string
     */
    protected $version = '1.0';

    /**
     * HTTP client used to make requests
     *
     * @var HttpClient|HttpAsyncClient
     */
    protected $http_client;

    /**
     * The choosen message factory
     *
     * @var RequestFactory
     */
    protected $message_factory;

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
    protected static $default_options = [
        'host' => 'api.starteed.com',
        'protocol' => 'https',
        'port' => 443,
        'key' => '',
        'version' => 'v1',
        'platform' => null,
        'language' => 'it_IT',
        'authorization' => null
    ];

    /**
     * Instance of Campaign class
     *
     * @var Platform
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
     * Sets up the Crowdfunding instance.
     *
     * @param HttpClient $http_client - An httplug client or adapter
     * @param array      $options     - An array to overide default options
     */
    public function __construct(HttpClient $http_client, array $options)
    {
        $this->setOptions($options);
        $this->setHttpClient($http_client);
        $this->_setupEndpoints();
    }

    /**
     * Sends sync request.
     *
     * @param string $method  The request method (GET|POST|PUT|PATCH|DELETE)
     * @param string $uri     The URI of endpoint
     * @param array  $payload Either used as the request body or URL query params
     * @param array  $headers Additional headers to send along with request
     *
     * @return CrowdfundingResponse Response due to sync request
     */
    public function request($method = 'GET', $uri = '', $payload = [], $headers = [])
    {
        $request = $this->buildRequest($method, $uri, $payload, $headers);
        try {
            return new StarteedResponse($this->http_client->sendRequest($request));

        } catch (Exception $exception) {
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
     * @return RequestInterface
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
        // Starteed Crowdfunding API will not tolerate form feed in JSON.
        $jsonReplace = [
            '\f' => '',
        ];
        $body = strtr(json_encode($body), $jsonReplace);
        return $this->_getMessageFactory()->createRequest($method, $url, $headers, $body);
    }

    /**
     * Returns an array for the request headers.
     *
     * @param array $headers - any custom headers for the request
     *
     * @return array $headers - headers for the request
     */
    public function getHttpHeaders($headers = [])
    {
        $constantHeaders = [
            'Accept' => 'application/x.crowdfunding.v1+json',
            'User-Agent' => 'php-starteed-crowdfunding/'.$this->version,
            'Content-Type' => 'application/json',
            'X-Relay-Host' => $this->options['platform'],
            'Accept-Language' => $this->options['language'],
            'Authorization' => null
        ];
        if (array_key_exists('authorization', $this->options) && $this->options['authorization']) {
            $constantHeaders['Authorization'] = 'Bearer ' . $this->options['authorization'];

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
     * @param HttpClient|HttpAsyncClient $http_client The client to be used for request
     *
     * @return void
     */
    public function setHttpClient(HttpClient $http_client)
    {
        if (!($http_client instanceof HttpAsyncClient || $http_client instanceof HttpClient)) {
            throw new LogicException(sprintf('Parameter to Crowdfunding::setHttpClient must be instance of "%s" or "%s"', HttpClient::class, HttpAsyncClient::class));

        }
        $this->http_client = $http_client;
    }

    /**
     * Sets the options from the param and defaults for the Starteed Crowdfunding object
     *
     * @param array $options Array of options: platform hostname is mandatory
     *
     * @return void
     */
    public function setOptions(array $options)
    {
        // Validate platform hostname because its required
        if (!isset($this->options['platform']) && (!isset($options['platform']))) {
            throw new Exception('You must provide a platform host string');

        }
        $this->options = isset($this->options) ? $this->options : self::$default_options;
        // set options, overriding defaults
        foreach ($options as $option => $value) {
            if (key_exists($option, $this->options)) {
                $this->options[$option] = $value;

            }

        }
    }

    /**
     * Sets up any endpoints to custom classes e.g. $this->campaigns.
     *
     * @return void
     */
    private function _setupEndpoints()
    {
        $this->platform = new Platform($this);
        $this->general = new General($this);
        $this->layout = new Layout($this);
        $this->versions = new Version($this);
        $this->campaigns = new Campaign($this);
        $this->sections = new Section($this);
    }

    /**
     * Return discovere and available Message Factory
     *
     * @return RequestFactory
     */
    private function _getMessageFactory()
    {
        if (!$this->message_factory) {
            $this->message_factory = MessageFactoryDiscovery::find();

        }
        return $this->message_factory;
    }

    /**
     * Enable override of Message Factory
     *
     * @param RequestFactory $message_factory The choosen message factory
     *
     * @return Crowdfunding
     */
    public function setMessageFactory(RequestFactory $message_factory)
    {
        $this->message_factory = $message_factory;
        return $this;
    }

    public function login($key)
    {
        $request = $this->buildRequest('POST', 'login', ['key' => $key], []);
        return new JWTResponse( $this->http_client->sendRequest($request) );
    }
}
