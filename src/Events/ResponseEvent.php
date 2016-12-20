<?php

namespace Starteed\Events;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * The starteed.response event is dispatched each time a response is provided by the API endpoint.
 */
class ResponseEvent extends Event
{
    const NAME = 'starteed.response';

    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
