<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\Contracts\RequestableInterface;

/**
 * @property float   $amount
 * @property integer $created_at Unix timestamp
 * @property object  $status
 */
class DonationResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\Resources\CampaignResource
     */
    protected $campaign;

    /**
     * @var \Starteed\Resources\DonorResource
     */
    protected $donor;

    /**
     * @var \Starteed\Resources\MethodResource
     */
    protected $method;

    /**
     * @param \Starteed\Resources\CampaignResource $campaignResource
     * @param array                                $data
     */
    public function __construct(CampaignResource $campaignResource, array $data)
    {
        $this->setData($data);

        $this->campaign = $campaignResource;
        $this->donor = new DonorResource($campaignResource, $this->original['donor']['data']);
        $this->method = new MethodResource($this->original['method']['data']);
    }

    /**
     * @return \Starteed\Resources\DonorResource
     */
    public function donor()
    {
        return $this->donor;
    }

    /**
     * @return \Starteed\Resources\MethodResource
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * @param array $emails
     *
     * @return array
     */
    public function share(array $emails)
    {
        return $this->post('share', [
            'emails' => $emails
        ])->getBody();
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri)
    {
        return "donations/{$this->original['id']}/{$uri}";
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
    public function put(string $uri, array $payload = [], array $headers = [])
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
    public function post(string $uri, array $payload = [], array $headers = [])
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
    public function delete(string $uri, array $payload = [], array $headers = [])
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
    public function patch(string $uri, array $payload = [], array $headers = [])
    {
        return $this->campaign->patch($this->getEndpointUri($uri), $payload, $headers);
    }
}