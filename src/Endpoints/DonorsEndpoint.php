<?php

namespace Starteed\Endpoints;

use Starteed\BaseRequest;
use Starteed\Contracts\ItemInterface;
use Starteed\Contracts\RequestableInterface;
use Starteed\Resources\DonorResource;
use Starteed\Resources\CampaignResource;
use Starteed\Contracts\CollectionInterface;

/**
 * Starteed Self Campaign donors endpoint
 *
 * Class that handles campaign donors
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class DonorsEndpoint extends BaseRequest implements ItemInterface, CollectionInterface
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
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri = '')
    {
        return "donors/{$uri}";
    }

    /**
     * Retrieve all donors
     *
     * @param array $options
     *
     * @return array
     */
    public function all(array $options =  [])
    {
        $response = $this->campaignResource->get($this->getEndpointUri(), $options);
        return array_map(function($donor) {
            return new DonorResource($this->campaignResource, $donor);
        }, $response->getBody()['data']);
    }

    /**
     * Retrieve donor by ID
     *
     * @param int   $id
     * @param array $options
     *
     * @return \Starteed\Resources\DonorResource
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = $this->campaignResource->get($this->getEndpointUri($id), $options)->getBody();
        return new DonorResource($this->campaignResource, $response['data']);
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