<?php

namespace Starteed\Endpoints;

use Starteed\BaseRequest;
use Starteed\Contracts\ItemInterface;
use Starteed\Resources\DonationResource;
use Starteed\Resources\CampaignResource;
use Starteed\Contracts\CollectionInterface;

/**
 * Starteed Self Campaign donations endpoint
 *
 * Class that handles campaign donations
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class DonationsEndpoint extends BaseRequest implements ItemInterface, CollectionInterface
{
    /**
     * @var \Starteed\Resources\CampaignResource $campaignResource
     */
    protected $campaignResource;

    /**
     * @param \Starteed\Resources\CampaignResource $campaignResource
     */
    public function __construct(CampaignResource $campaignResource)
    {
        $this->campaignResource = $campaignResource;
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri = ''): string
    {
        return "donations/{$uri}";
    }

    /**
     * Retrieve all donations
     *
     * @param array $options Request payload
     *
     * @return \Starteed\Resources\RewardResource[] Campaign resource to access related data
     */
    public function all(array $options = []): array
    {
        $response = $this->campaignResource->get($this->getEndpointUri(), $options);

        $this->setMeta($response['meta']);

        return array_map(function($donation) {
            return new DonationResource($this->campaignResource, $donation);
        }, $response->getBody()['data']);
    }

    /**
     * Retrieve single donation by ID
     *
     * @param int   $id
     * @param array $options
     *
     * @return \Starteed\Resources\DonationResource
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = $this->campaignResource->get($this->getEndpointUri($id), $options)->getBody();

        $this->setMeta($response['meta']);

        return new DonationResource($this->campaignResource, $response['data']);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function get(string $uri, array $payload, array $headers)
    {
        return $this->campaignResource->get($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->campaignResource->put($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->campaignResource->post($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->campaignResource->delete($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->campaignResource->patch($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * Search donations by values
     *
     * @param array $payload Request payload
     *
     * @return \Starteed\Resources\DonationResource[] Donation resource to access related data
     */
    public function search(array $payload)
    {
        $response = $this->campaignResource->get($this->getEndpointUri('search'), $payload)->getBody();

        $this->setMeta($response['meta']);

        return array_map(function($donation) {
            return new DonationResource($this->campaignResource, $donation);
        }, $response['data']);
    }

    /**
     * Retrieve all completed donations
     *
     * @param int $page
     *
     * @return \Starteed\Resources\DonationResource[]
     */
    public function completed(int $page = 1)
    {
        return $this->search([
            'where' => [
                'IDEXT_ProjectStatusPayment' => 2
            ],
            'limit' => 24,
            'page' => $page,
            'order_by'
        ]);
    }
}