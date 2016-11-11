<?php

namespace Starteed\Resources;

use Starteed\Crowdfunding;

/**
 * Class ResourceBase
 * @package Starteed
 */
class ResourceBase
{
    /**
     * Starteed object used to make requests.
     */
    protected $starteed;

    /**
     * The api endpoint that gets prepended to all requests send through this resource.
     */
    protected $endpoint;

    /**
     * The resource data given by the API request.
     */
    protected $resource;

    /**
     * Sets up the Resource.
     *
     * @param Crowdfunding $starteed - the Starteed Crowdfunding instance that this resource is attached to
     * @param string       $endpoint - the endpoint that this resource wraps
     */
    public function __construct(Crowdfunding $starteed, $endpoint)
    {
        $this->starteed = $starteed;
        $this->endpoint = $endpoint;
    }
    /**
     * Magic method __call is optimized to return value from template engine like Twig.
     *
     * @param string $method the method to invoke
     * @param array  $args   the parameters to pass to function
     *
     * @return mixed Return property or function return
     */
    public function __call($method, $args)
    {
        if (
            is_array($args) and count($args) == 0
            && !method_exists($this, $method)
        ) {
            return $this->__get($method);

        }
    }
    /**
     * Basic getter lookin in protected property $resource 
     *
     * @param string $property the property to look for
     *
     * @return mixed|null the resource property or null if not found
     */
    public function __get($property)
    {
        if (property_exists($this->resource, $property)) {
          return $this->resource->$property;

        }
    }

    /**
     * Sends get request to API at the set endpoint.
     *
     * @see Starteed->request()
     */
    public function get($uri = '', $payload = [], $headers = [])
    {
        return $this->request('GET', $uri, $payload, $headers);
    }

    /**
     * Sends put request to API at the set endpoint.
     *
     * @see Starteed->request()
     */
    public function put($uri = '', $payload = [], $headers = [])
    {
        return $this->request('PUT', $uri, $payload, $headers);
    }

    /**
     * Sends post request to API at the set endpoint.
     *
     * @see Starteed->request()
     */
    public function post($payload = [], $headers = [])
    {
        return $this->request('POST', '', $payload, $headers);
    }

    /**
     * Sends delete request to API at the set endpoint.
     *
     * @see Starteed->request()
     */
    public function delete($uri = '', $payload = [], $headers = [])
    {
        return $this->request('DELETE', $uri, $payload, $headers);
    }

    /**
     * Sends requests to Starteed object to the resource endpoint.
     *
     * @see Starteed->request()
     *
     * @return StarteedResponse
     */
    public function request($method = 'GET', $uri = '', $payload = [], $headers = [])
    {
        if (is_array($uri)) {
            $headers = $payload;
            $payload = $uri;
            $uri = '';
        }

        $uri = $this->endpoint.'/'.$uri;

        return $this->starteed->request($method, $uri, $payload, $headers);
    }
}