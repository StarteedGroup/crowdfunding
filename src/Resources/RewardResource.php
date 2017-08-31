<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\Endpoints\RewardsEndpoint;
use Starteed\Contracts\RequestableInterface;

/**
 * @property int|null $remaining
 * @property int|null $usage
 */
class RewardResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\Resources\RewardTranslationResource
     */
    protected $translation;

    /**
     * @var \Starteed\Endpoints\RewardsEndpoint
     */
    protected $rewardsEndpoint;

    /**
     * @param \Starteed\Endpoints\RewardsEndpoint $rewardsEndpoint
     * @param array                               $data
     */
    public function __construct(RewardsEndpoint $rewardsEndpoint, array $data)
    {
        $this->setData($data);

        $this->rewardsEndpoint = $rewardsEndpoint;

        $this->translation = new RewardTranslationResource($this, $data['translation']['data']);
    }

    /**
     * @return \Starteed\Resources\RewardTranslationResource
     */
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
        return "{$this->original['id']}/{$uri}";
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
        return $this->rewardsEndpoint->get($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->rewardsEndpoint->put($uri, $payload, $headers);
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
        return $this->rewardsEndpoint->post($uri, $payload, $headers);
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
        return $this->rewardsEndpoint->delete($uri, $payload, $headers);
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
        return $this->rewardsEndpoint->patch($uri, $payload, $headers);
    }
}