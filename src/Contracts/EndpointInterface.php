<?php

namespace Starteed\Contracts;

use Starteed\SelfCrowdfunding;

interface EndpointInterface
{
    /**
     * @return \Starteed\SelfCrowdfunding
     */
    public function getStarteedEndpoint();

    /**
     * @param \Starteed\SelfCrowdfunding $endpoint
     */
    public function setStarteedEndpoint(SelfCrowdfunding $endpoint);
}