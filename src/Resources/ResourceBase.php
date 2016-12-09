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
     * The original data given by the API request.
     */
    protected $original;

    /**
     * Sets up the Resource.
     *
     * @param Crowdfunding $starteed The Starteed Crowdfunding instance that this resource is attached to
     * @param string       $endpoint The endpoint that this resource wraps
     * @param array        $original The data obtained by the request
     */
    public function __construct(Crowdfunding $starteed, $endpoint, array $original = null)
    {
        $this->starteed = $starteed;
        $this->endpoint = $endpoint;
        $this->original = $this->setOriginal($original);
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
    public function post(array $payload = [], array $headers = [])
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

    /**
     * Declare all properties from request response in order to make them available
     * as public property.
     *
     * @param array $original The array obtained via request
     *
     * @return array The response data
     */
    public function setOriginal(array $original = null)
    {
        if ($original) {
            $original = json_decode(json_encode($original));
            foreach ($original as $key => $value) {
                $this->$key = $value;

            }
            return $original;

        }
    }

    public function getOriginal()
    {
        return $this->original;
    }

    public static function unserialize(Crowdfunding $starteed, $data)
    {
        return new static($starteed, json_decode(json_encode($data), true));
    }

    /**
     * Getter method to access protected related resources
     *
     * @return mixed Property value if exists or null if not found
     */
    public function __get($property)
    {
        return property_exists($this, $property) ? $this->{$property} : null;
    }
}