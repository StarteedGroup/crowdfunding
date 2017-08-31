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
    /**
     * @const Event name
     */
    const NAME = 'starteed.blacklisted';

    /**
     * @var \Starteed\SelfCrowdfunding
     */
    protected $starteed;

    /**
     * @var \Psr\Http\Message\RequestInterface
     */
    protected $request;

    /**
     * @param \Starteed\SelfCrowdfunding         $starteed
     * @param \Psr\Http\Message\RequestInterface $request
     */
    public function __construct(SelfCrowdfunding $starteed, RequestInterface $request)
    {
        $this->starteed = $starteed;
        $this->request = $request;
    }

    /**
     * @param $key
     *
     * @return \Starteed\Responses\JWTResponse
     */
    public function getNewToken($key)
    {
        return $this->starteed->login($key);
    }

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }
}
