<?php

namespace Starteed\Endpoints;

use Starteed\BaseRequest;
use Starteed\Contracts\ItemInterface;
use Starteed\Resources\RewardResource;
use Starteed\Resources\CampaignResource;
use Starteed\Contracts\CollectionInterface;

/**
 * Starteed Self rewards endpoint
 *
 * Class that handles campaign rewards
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class RewardsEndpoint extends BaseRequest implements ItemInterface, CollectionInterface
{
    /**
     * @var \Starteed\Resources\CampaignResource
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
     * Retrieve collection of campaign rewards
     *
     * @param array $options
     *
     * @return \Starteed\Resources\RewardResource[]
     */
    public function all(array $options = [])
    {
        $response = $this->campaignResource->get($this->getEndpointUri(), $options);
        return array_map(function($reward) {
            return new RewardResource($this, $reward);
        }, $response->getBody()['data']);
    }

    /**
     * Retrieve campaign reward by ID
     *
     * @param int   $id
     * @param array $options
     *
     * @return \Starteed\Resources\RewardResource
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = $this->campaignResource->get($this->getEndpointUri($id), $options)->getBody();
        return new RewardResource($this, $response['data']);
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri = '')
    {
        return "rewards/{$uri}";
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
}