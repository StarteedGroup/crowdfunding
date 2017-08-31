<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\Contracts\RequestableInterface;

class RewardTranslationResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\Resources\RewardResource
     */
    protected $rewardResource;

    /**
     * @param \Starteed\Resources\RewardResource $rewardResource
     * @param array                              $data
     */
    public function __construct(RewardResource $rewardResource, array $data)
    {
        $this->rewardResource = $rewardResource;
        $this->setData($data);
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri): string
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
        return $this->rewardResource->get($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->rewardResource->put($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->rewardResource->post($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->rewardResource->delete($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->rewardResource->patch($this->getEndpointUri($uri), $payload, $headers);
    }
}
