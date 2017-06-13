<?php

namespace Starteed;

use Starteed\Contracts\RequestableInterface;
use Starteed\Responses\StarteedResponse;

abstract class BaseRequest implements RequestableInterface
{
    /**
     * @var \Starteed\SelfCrowdfunding
     */
    protected $endpoint;

    /**
     * @return \Starteed\SelfCrowdfunding
     */
    public function getStarteedEndpoint(): SelfCrowdfunding
    {
        return $this->endpoint;
    }

    /**
     * @param \Starteed\SelfCrowdfunding $endpoint
     *
     * @return mixed
     */
    public function setStarteedEndpoint(SelfCrowdfunding $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return mixed
     */
    public function get(string $uri, array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->getStarteedEndpoint()->request('GET', $uri, $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return mixed
     */
    public function put(string $uri, array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->getStarteedEndpoint()->request('PUT', $uri, $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return mixed|\Starteed\Responses\StarteedResponse
     */
    public function post(string $uri, array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->getStarteedEndpoint()->request('POST', '', $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return mixed|\Starteed\Responses\StarteedResponse
     */
    public function delete(string $uri, array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->getStarteedEndpoint()->request('DELETE', '', $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return mixed|\Starteed\Responses\StarteedResponse
     */
    public function patch(string $uri, array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->getStarteedEndpoint()->request('PATCH', '', $payload, $headers);
    }

}