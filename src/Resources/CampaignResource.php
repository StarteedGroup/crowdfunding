<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\Endpoints\FaqsEndpoint;
use Starteed\Endpoints\UpdatesEndpoint;
use Starteed\Endpoints\RewardsEndpoint;
use Starteed\Endpoints\CampaignsEndpoint;
use Starteed\Endpoints\DonationsEndpoint;
use Starteed\Contracts\RequestableInterface;

/**
 * Class CampaignResource
 *
 * @property int    $id
 * @property object $duration
 * @property object $status
 * @property float  $raised
 * @property float  $goal
 * @property object $social
 * @property \Starteed\Resources\FundingResource             $funding
 * @property \Starteed\Resources\CurrencyResource            $currency
 * @property \Starteed\Resources\CampaignTranslationResource $translation
 * @property object $bank_account
 * @property object $wizard
 * @property string $rewrite
 *
 * @package Starteed\Resources
 */
class CampaignResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\Endpoints\CampaignsEndpoint
     */
    protected $campaignsEndpoint;

    /**
     * @var \Starteed\Endpoints\RewardsEndpoint
     */
    protected $rewardsEndpoint;

    /**
     * @var \Starteed\Endpoints\DonationsEndpoint
     */
    protected $donationsEndpoint;

    /**
     * @var \Starteed\Endpoints\UpdatesEndpoint
     */
    protected $updatesEndpoint;

    /**
     * @var \Starteed\Endpoints\FaqsEndpoint
     */
    protected $faqsEndpoint;

    /**
     * @param \Starteed\Endpoints\CampaignsEndpoint $campaignsEndpoint
     * @param array                                 $data
     */
    public function __construct(CampaignsEndpoint $campaignsEndpoint, array $data = [])
    {
        $this->campaignsEndpoint = $campaignsEndpoint;

        $this->setData($data);

        $this->rewardsEndpoint = new RewardsEndpoint($this);
        $this->donationsEndpoint = new DonationsEndpoint($this);
        $this->updatesEndpoint = new UpdatesEndpoint($this);
        $this->faqsEndpoint = new FaqsEndpoint($this);

        $this->currency = new CurrencyResource($data['currency']['data']);
        $this->funding = new FundingResource($data['funding']['data']);
        $this->translation = new CampaignTranslationResource($this, $data['translation']['data']);
    }

    /**
     * @return \Starteed\Endpoints\RewardsEndpoint
     */
    public function rewards()
    {
        return $this->rewardsEndpoint;
    }

    /**
     * @return \Starteed\Endpoints\DonationsEndpoint
     */
    public function donations()
    {
        return $this->donationsEndpoint;
    }

    /**
     * @return \Starteed\Endpoints\UpdatesEndpoint
     */
    public function updates()
    {
        return $this->updatesEndpoint;
    }

    /**
     * @return \Starteed\Endpoints\FaqsEndpoint
     */
    public function faqs()
    {
        return $this->faqsEndpoint;
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri): string
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
        return $this->campaignsEndpoint->get($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->campaignsEndpoint->put($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->campaignsEndpoint->post($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->campaignsEndpoint->delete($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->campaignsEndpoint->patch($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param array $params
     *
     * @return \Starteed\Resources\DonationResource
     */
    public function donate(array $params)
    {
        $donation = new DonationsEndpoint($this);
        $response = $donation->post('', $params, []);
        return new DonationResource($this, $response->getBody()['data']);
    }
}
