<?php

namespace Starteed;

use Starteed\Contracts\CollectionInterface;
use Starteed\Contracts\ItemInterface;
use Starteed\Resources\CampaignResource;
use Starteed\Responses\StarteedResponse;

/**
 * Starteed Self Crowdfunding Campaigns
 *
 * API endpoint related to Starteed SELF Platform campaigns.
 *
 * PHP version 7.0
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
     * Starteed Self instance in order to make requests
     *
     * @var SelfCrowdfunding
     */
    protected $starteed;

    /**
     * @var array|\Starteed\Resources\CampaignResource[]
     */
    protected $resource;

    /**
     * Sets up the Platform instance.
     *
     * @param SelfCrowdfunding $starteed Self instance in order to make requests
     */
    public function __construct(SelfCrowdfunding $starteed)
    {
        $this->setStarteedEndpoint($starteed);
    }

    /**
     * @param \Starteed\Responses\StarteedResponse $response
     *
     * @return array
     */
    private function extractCampaignResources(StarteedResponse $response): array
    {
        $body = $response->getBody();
        $meta = array_key_exists('meta', $body) ? $body['meta'] : [];
        if (array_key_exists('data', $body)) {
            return array_map(function($resource) use ($meta) {
                return new CampaignResource($this, $resource, $meta);
            }, $body['data']);
        }
        return [];
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
     * Retrieve all campaigns
     *
     * @param array $options Request payload
     *
     * @return array|\Starteed\Resources\CampaignResource[] Campaign resource to access related data
     */
    public function all(array $options = []): array
    {
        if (!$this->resource) {
            $response = parent::get($this->getEndpointUri(), $options);
            $this->resource = $this->extractCampaignResources($response);
        }
        return $this->resource;
    }

    /**
     * @param int|null  $id
     * @param array     $options
     *
     * @return \Starteed\Resources\CampaignResource
     */
    public function retrieve($id = null, array $options = []): CampaignResource
    {
        $response = parent::get($this->getEndpointUri($id), $options)->getBody();
        return new CampaignResource($this, $response['data'], $response['meta']);
    }
}