<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\Contracts\RequestableInterface;
use Starteed\Endpoints\UpdatesEndpoint;

class UpdateResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\Endpoints\UpdatesEndpoint
     */
    protected $updatesEndpoint;

    /**
     * @var \Starteed\Resources\UpdateTranslationResource
     */
    protected $translation;

    /**
     * @param \Starteed\Endpoints\UpdatesEndpoint $updatesEndpoint
     * @param array                               $data
     */
    public function __construct(UpdatesEndpoint $updatesEndpoint, array $data)
    {
        $this->setData($data);

        $this->updatesEndpoint = $updatesEndpoint;

        $this->translation = new UpdateTranslationResource($this, $this->original['translation']['data']);
    }

    public function translation()
    {
        return $this->translation;
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri)
    {
        return "{$this->original['id']}/$uri";
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function get(string $uri, array $payload = [], array $headers = [])
    {
        return $this->updatesEndpoint->get($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function put(string $uri, array $payload = [], array $headers = [])
    {
        return $this->updatesEndpoint->put($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function post(string $uri, array $payload = [], array $headers = [])
    {
        return $this->updatesEndpoint->post($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function delete(string $uri, array $payload = [], array $headers = [])
    {
        return $this->updatesEndpoint->delete($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function patch(string $uri, array $payload = [], array $headers = [])
    {
        return $this->updatesEndpoint->patch($this->getEndpointUri($uri), $payload, $headers);
    }
}