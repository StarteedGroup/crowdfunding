<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\Contracts\RequestableInterface;

class UpdateTranslationResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\Resources\UpdateResource
     */
    private $updateResource;

    /**
     * @param \Starteed\Resources\UpdateResource $updateResource
     * @param array                              $data
     */
    public function __construct(UpdateResource $updateResource, array $data)
    {
        $this->updateResource = $updateResource;

        $this->setData($data);
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri)
    {
        return "translations/{$this->original['id']}/{$uri}";
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
        return $this->updateResource->get($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->updateResource->put($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->updateResource->post($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->updateResource->delete($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->updateResource->patch($this->getEndpointUri($uri), $payload, $headers);
    }
}