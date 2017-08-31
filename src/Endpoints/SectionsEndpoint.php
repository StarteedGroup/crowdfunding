<?php

namespace Starteed\Endpoints;

use Starteed\BaseRequest;
use Starteed\SelfCrowdfunding;
use Starteed\Contracts\ItemInterface;
use Starteed\Resources\SectionResource;
use Starteed\Contracts\CollectionInterface;

/**
 * Starteed Self Sections endpoint
 *
 * Endpoint class to access platform sections
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class SectionsEndpoint extends BaseRequest implements ItemInterface, CollectionInterface
{
    /**
     * @param \Starteed\SelfCrowdfunding $starteed Starteed SELF instance in order to make requests
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
    public function getEndpointUri(string $uri = null)
    {
        return "sections/{$uri}";
    }

    /**
     * Retrieve all platform sections
     *
     * @param array $options
     *
     * @return array|\Starteed\Resources\SectionResource[]
     */
    public function all(array $options = [])
    {
        $response = $this->getStarteedEndpoint()->request('GET', $this->getEndpointUri(), $options)->getBody();
        return array_map(function($section) {
            return new SectionResource($this, $section);
        }, $response['data']);
    }

    /**
     * Retrieve platform section by ID
     *
     * @param int   $id
     * @param array $options
     *
     * @return \Starteed\Resources\SectionResource
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = $this->getStarteedEndpoint()->request('GET', $this->getEndpointUri($id), $options)->getBody();
        return new SectionResource($this, $response['data']);
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