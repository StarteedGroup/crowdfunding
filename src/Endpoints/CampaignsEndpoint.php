<?php

namespace Starteed\Endpoints;

use Starteed\BaseRequest;
use Starteed\SelfCrowdfunding;
use Starteed\Contracts\ItemInterface;
use Starteed\Resources\CampaignResource;
use Starteed\Responses\StarteedResponse;
use Starteed\Contracts\CollectionInterface;

/**
 * Starteed SELF Crowdfunding Campaigns endpoint
 *
 * API endpoint related to platform campaigns.
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class CampaignsEndpoint extends BaseRequest implements ItemInterface, CollectionInterface
{
    /**
     * Sets up the Platform instance.
     *
     * @param \Starteed\SelfCrowdfunding $self Starteed SELF instance in order to make requests
     */
    public function __construct(SelfCrowdfunding $self)
    {
        $this->setStarteedEndpoint($self);
    }

    /**
     * Retrieve all campaigns
     *
     * @param array $options Request payload
     *
     * @return array|\Starteed\Resources\CampaignResource[] Campaign resource to access related data
     */
    public function all(array $options = []): array
    {
        $response = $this->get('', $options, []);
        return $this->extractCampaignResources($response);
    }

    /**
     * Retrieve single campaign by ID
     *
     * @param int|null  $id
     * @param array     $options
     *
     * @return \Starteed\Resources\CampaignResource
     */
    public function retrieve(int $id = null, array $options = []): CampaignResource
    {
        $response = $this->get($id, $options, [])->getBody();
        return new CampaignResource($this, $response['data']);
    }

    /**
     * @param \Starteed\Responses\StarteedResponse $response
     *
     * @return array
     */
    private function extractCampaignResources(StarteedResponse $response): array
    {
        return array_map(function($campaign) {
            return new CampaignResource($this, $campaign);
        }, $response->getBody()['data']);
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri = ''): string
    {
        return "campaigns/{$uri}";
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
        return $this->getStarteedEndpoint()->request('GET', $this->getEndpointUri($uri), $payload, $headers);
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
        return $this->getStarteedEndpoint()->request('PUT', $this->getEndpointUri($uri), $payload, $headers);
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
        return $this->getStarteedEndpoint()->request('POST', $this->getEndpointUri($uri), $payload, $headers);
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
        return $this->getStarteedEndpoint()->request('DELETE', $this->getEndpointUri($uri), $payload, $headers);
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
        return $this->getStarteedEndpoint()->request('PATCH', $this->getEndpointUri($uri), $payload, $headers);
    }
}