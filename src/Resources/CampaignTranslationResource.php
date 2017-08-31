<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\Contracts\RequestableInterface;

/**
 * @property string $about_us
 * @property string $title
 * @property string $abstract
 * @property object $share
 */
class CampaignTranslationResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\Resources\CampaignResource
     */
    protected $campaign;

    /**
     * @param \Starteed\Resources\CampaignResource $campaign
     * @param array                                $data
     */
    public function __construct(CampaignResource $campaign, array $data)
    {
        $this->setData($data);
        $this->campaign = $campaign;
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
        return $this->campaign->get($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function put(string $uri, array $payload, array $headers)
    {
        return $this->campaign->put($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function post(string $uri, array $payload, array $headers)
    {
        return $this->campaign->post($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function delete(string $uri, array $payload, array $headers)
    {
        return $this->campaign->delete($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function patch(string $uri, array $payload, array $headers)
    {
        return $this->campaign->patch($this->getEndpointUri($uri), $payload, $headers);
    }
}