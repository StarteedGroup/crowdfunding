<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\Contracts\RequestableInterface;

class LocaleResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\Resources\PlatformResource
     */
    protected $platformResource;

    /**
     * @var \Starteed\Resources\LanguageResource
     */
    protected $language;

    /**
     * @param \Starteed\Resources\PlatformResource $platformResource
     * @param array                                $data
     */
    public function __construct(PlatformResource $platformResource, array $data)
    {
        $this->setData($data);

        $this->platformResource = $platformResource;

        $this->language = new LanguageResource($data['language']['data']);
    }

    /**
     * @return \Starteed\Resources\LanguageResource
     */
    public function language()
    {
        return $this->language;
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri = '')
    {
        return "locales/{$this->original['id']}/{$uri}";
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
        return $this->platformResource->get($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->platformResource->put($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->platformResource->post($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->platformResource->delete($this->getEndpointUri($uri), $payload, $headers);
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
        return $this->platformResource->patch($this->getEndpointUri($uri), $payload, $headers);
    }
}
