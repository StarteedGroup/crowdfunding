<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\Endpoints\FaqsEndpoint;
use Starteed\Contracts\RequestableInterface;

class FaqResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\Endpoints\FaqsEndpoint
     */
    protected $faqsEndpoint;

    /**
     * @var \Starteed\Resources\FaqTranslationResource
     */
    protected $translation;

    /**
     * @param \Starteed\Endpoints\FaqsEndpoint $faqsEndpoint
     * @param array                            $data
     */
    public function __construct(FaqsEndpoint $faqsEndpoint, array $data)
    {
        $this->faqsEndpoint = $faqsEndpoint;
        
        $this->setData($data);

        $this->translation = new FaqTranslationResource($faqsEndpoint, $this->original['translation']['data']);
    }

    public function translation()
    {
        return $this->translation;
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri = '')
    {
        return "{$this->original['id']}/$uri";
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
        return $this->faqsEndpoint->get($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->faqsEndpoint->put($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->faqsEndpoint->post($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->faqsEndpoint->delete($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->faqsEndpoint->patch($this->getEndpointUri($uri), $payload, $headers);
    }
}