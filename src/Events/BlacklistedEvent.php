<?php

namespace Starteed\Events;

use Starteed\SelfCrowdfunding;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * The starteed.blacklisted event is dispatched each time an exception of Token blacklisting is throwned by the API endpoint.
 */
class BlacklistedEvent extends Event
{
    const NAME = 'starteed.blacklisted';

    protected $starteed;
    protected $request;

    public function __construct(SelfCrowdfunding $starteed, RequestInterface $request)
    {
        $this->starteed = $starteed;
        $this->request = $request;
    }

    public function getNewToken($key)
    {
        return $this->starteed->login($key);
    }

    public function getRequest()
    {
        return $this->request;
    }
}
