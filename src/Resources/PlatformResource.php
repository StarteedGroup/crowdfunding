<?php

namespace Starteed\Resources;

use Starteed\BaseResource;
use Starteed\Endpoints\PlatformEndpoint;
use Starteed\Responses\StarteedResponse;
use Starteed\Contracts\RequestableInterface;

/**
 * @property string $title
 */
class PlatformResource extends BaseResource implements RequestableInterface
{
    /**
     * @var \Starteed\Endpoints\PlatformEndpoint
     */
    protected $platformEndpoint;

    /**
     * @var \Starteed\Resources\CurrencyResource
     */
    private $currencyResource;

    /**
     * @var \Starteed\Resources\LayoutResource
     */
    protected $layoutResource;

    /**
     * @var \Starteed\Resources\LocaleResource[]
     */
    protected $localeResources;

    /**
     * PlatformResource constructor.
     *
     * @param \Starteed\Endpoints\PlatformEndpoint $platformEndpoint
     * @param array                                $data
     */
    public function __construct(PlatformEndpoint $platformEndpoint, array $data)
    {
        $this->platformEndpoint = $platformEndpoint;
        $this->setData($data);

        $this->layoutResource = new LayoutResource($this, $this->original['layout']['data']);
        $this->currencyResource = new CurrencyResource($this->original['currency']['data']);
        $this->localeResources = array_map(function($locale) {
            return new LocaleResource($this, $locale);
        }, $this->original['locales']['data']);
    }

    /**
     * @return \Starteed\Resources\LayoutResource
     */
    public function layout()
    {
        return $this->layoutResource;
    }

    /**
     * @return \Starteed\Resources\LocaleResource[]
     */
    public function locales()
    {
        return $this->localeResources;
    }

    /**
     * @return \Starteed\Resources\CurrencyResource
     */
    public function currency()
    {
        return $this->currencyResource;
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri): string
    {
        return $uri;
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function get(string $uri = '', array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->platformEndpoint->get($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function put(string $uri = '', array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->platformEndpoint->put($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function post(string $uri = '', array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->platformEndpoint->post($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function delete(string $uri = '', array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->platformEndpoint->delete($this->getEndpointUri($uri), $payload, $headers);
    }

    /**
     * @param string $uri
     * @param array  $payload
     * @param array  $headers
     *
     * @return \Starteed\Responses\StarteedResponse
     */
    public function patch(string $uri = '', array $payload = [], array $headers = []): StarteedResponse
    {
        return $this->platformEndpoint->patch($this->getEndpointUri($uri), $payload, $headers);
    }
}
