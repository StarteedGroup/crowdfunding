<?php

namespace Starteed\Contracts;

use Starteed\Responses\StarteedResponse;
use Starteed\SelfCrowdfunding;

interface RequestableInterface
{
    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri): string;

    /**
     * @return \Starteed\SelfCrowdfunding
     */
    public function getStarteedEndpoint(): SelfCrowdfunding;

    /**
     * @param \Starteed\SelfCrowdfunding $endpoint
     *
     * @return mixed
     */
    public function setStarteedEndpoint(SelfCrowdfunding $endpoint);

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function get(string $uri, array $payload = [], array $headers = []): StarteedResponse;

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function put(string $uri, array $payload = [], array $headers = []): StarteedResponse;

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function post(string $uri, array $payload = [], array $headers = []): StarteedResponse;

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function delete(string $uri, array $payload = [], array $headers = []): StarteedResponse;

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function patch(string $uri, array $payload = [], array $headers = []): StarteedResponse;
}