<?php

namespace Starteed;

use Starteed\Contracts\EndpointInterface;
use Starteed\Contracts\RequestableInterface;

abstract class BaseRequest implements RequestableInterface, EndpointInterface
{
    /**
     * @var \Starteed\SelfCrowdfunding
     */
    protected $endpoint;

    /**
     * @var array
     */
    protected $meta;

    /**
     * @param array $meta
     */
    final public function setMeta(array $meta)
    {
        $this->meta = $meta;
    }

    /**
     * @return array
     */
    final public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @return \Starteed\SelfCrowdfunding
     */
    final public function getStarteedEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param \Starteed\SelfCrowdfunding $endpoint
     */
    final public function setStarteedEndpoint(SelfCrowdfunding $endpoint)
    {
        $this->endpoint = $endpoint;
    }
}