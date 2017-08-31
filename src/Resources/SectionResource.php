<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\Endpoints\SectionsEndpoint;
use Starteed\Contracts\RequestableInterface;

class SectionResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\Endpoints\SectionsEndpoint
     */
    protected $sectionsEndpoint;

    /**
     * @var \Starteed\Resources\SectionTranslationResource
     */
    protected $translation;

    /**
     * @param \Starteed\Endpoints\SectionsEndpoint $sectionsEndpoint
     * @param array                                $data
     */
    public function __construct(SectionsEndpoint $sectionsEndpoint, array $data)
    {
        $this->sectionsEndpoint = $sectionsEndpoint;

        $this->setData($data);

        $this->translation = new SectionTranslationResource($this, $this->original['translation']['data']);
    }

    /**
     * @return \Starteed\Resources\SectionTranslationResource
     */
    public function translation()
    {
        return $this->translation;
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri)
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
        return $this->sectionsEndpoint->get($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->sectionsEndpoint->put($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->sectionsEndpoint->post($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->sectionsEndpoint->delete($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->sectionsEndpoint->patch($this->getEndpointUri($uri), $payload, $headers);
    }
}