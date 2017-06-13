<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\PlatformEndpoint;
use Starteed\SelfCrowdfunding;
use Starteed\Responses\StarteedResponse;
use Starteed\Contracts\RequestableInterface;

class PlatformResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\PlatformEndpoint
     */
    protected $endpoint;

    /**
     * @var array
     */
    private $original;

    /**
     * @var array
     */
    private $meta;

    /**
     * @var array
     */
    public $data;

    /**
     * PlatformResource constructor.
     *
     * @param \Starteed\PlatformEndpoint           $platformEndpoint
     * @param \Starteed\Responses\StarteedResponse $response
     */
    public function __construct(PlatformEndpoint $platformEndpoint, StarteedResponse $response)
    {
        $this->endpoint = $platformEndpoint;

        $body = $response->getBody();
        $this->meta = array_key_exists('meta', $body) ? $body['meta'] : [];
        $this->data = array_key_exists('data', $body) ? $body['data'] : [];
        /*
         * Original data is private in order to do comparison for PATCH request auto-completion
         */
        $this->original = $this->data;
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri): string
    {
        return $this->endpoint->getEndpointUri($uri);
    }

    /**
     * @return \Starteed\SelfCrowdfunding
     */
    public function getStarteedEndpoint(): SelfCrowdfunding
    {
        return $this->endpoint->getStarteedEndpoint();
    }

    /**
     * @param \Starteed\SelfCrowdfunding $endpoint
     *
     * @return mixed
     */
    public function setStarteedEndpoint(SelfCrowdfunding $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function get(string $uri = '', array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->endpoint->get($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function put(string $uri = '', array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->endpoint->put($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function post(string $uri = '', array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->endpoint->post($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function delete(string $uri = '', array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->endpoint->delete($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function patch(string $uri = '', array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->endpoint->patch($this->getEndpointUri($uri), $payload, $headers);
    }
}
