<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\CampaignsEndpoint;
use Starteed\SelfCrowdfunding;
use Starteed\Responses\StarteedResponse;
use Starteed\Contracts\RequestableInterface;

class CampaignResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\CampaignsEndpoint
     */
    protected $campaignsEndpoint;

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

    public function __construct(CampaignsEndpoint $campaignsEndpoint, array $data = [], array $meta)
    {
        $this->campaignsEndpoint = $campaignsEndpoint;
        $this->data = $data;
        $this->meta = $meta;
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
        return "{$this->campaignsEndpoint->getEndpointUri($this->original['id'])}/{$uri}";
    }

    /**
     * @return \Starteed\SelfCrowdfunding
     */
    public function getStarteedEndpoint(): SelfCrowdfunding
    {
        return $this->campaignsEndpoint->getStarteedEndpoint();
    }

    /**
     * @param \Starteed\SelfCrowdfunding $campaignsEndpoint
     *
     * @return mixed
     */
    public function setStarteedEndpoint(SelfCrowdfunding $campaignsEndpoint)
    {
        $this->campaignsEndpoint = $campaignsEndpoint;
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
        return $this->campaignsEndpoint->get($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->campaignsEndpoint->put($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->campaignsEndpoint->post($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->campaignsEndpoint->delete($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->campaignsEndpoint->patch($this->getEndpointUri($uri), $payload, $headers);
    }
}
