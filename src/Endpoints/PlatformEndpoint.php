<?php

namespace Starteed\Endpoints;

use Starteed\BaseRequest;
use Starteed\SelfCrowdfunding;
use Starteed\Contracts\ItemInterface;
use Starteed\Resources\PlatformResource;

/**
 * Starteed Self Platform endpoint
 *
 * API endpoint related to Starteed SELF Platform
 *
 * PHP version 7.0
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class PlatformEndpoint extends BaseRequest implements ItemInterface
{

    /**
     * @param SelfCrowdfunding $starteed Self instance in order to make requests
     */
    public function __construct(SelfCrowdfunding $starteed)
    {
        $this->setStarteedEndpoint($starteed);
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri = '')
    {
        return "platform/{$uri}";
    }

    /**
     * Retrieve platform
     *
     * @param int|null $id
     * @param array    $options Request payload
     *
     * @return \Starteed\Resources\PlatformResource Platform resource to access related data
     */
    public function retrieve(int $id = null, array $options = [])
    {
        $response = $this->getStarteedEndpoint()->request('GET', $this->getEndpointUri(), $options)->getBody();
        return new PlatformResource($this, $response['data']);
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