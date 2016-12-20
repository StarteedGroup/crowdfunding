<?php

namespace Starteed\Responses;

use Starteed\Crowdfunding;
use Starteed\Events\ResponseEvent;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;


class StarteedResponse implements ResponseInterface
{
    /**
     * ResponseInterface to be wrapped by StarteedResponse
     *
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Event dispatcher for Response
     *
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * Set up the response to be wrapped
     *
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        // create the ResponseEvent and dispatching it
        $event = new ResponseEvent($this->response);
        Crowdfunding::dispatch(ResponseEvent::NAME, $event);
    }

    /**
     * Returns the body
     *
     * @return array $body - the json decoded body from the http response
     */
    public function getBody()
    {
        $body = $this->response->getBody();
        $body_string = $body->__toString();
        $json = json_decode($body_string, true);
        return $json;
    }

    /**
     * Pass these down to the response given in the constructor
     */
    public function getProtocolVersion()
    {
        return $this->response->getProtocolVersion();
    }

    public function withProtocolVersion($version)
    {
        return $this->response->withProtocolVersion($version);
    }

    public function getHeaders()
    {
        return $this->response->getHeaders();
    }

    public function hasHeader($name)
    {
        return $this->response->hasHeader($name);
    }

    public function getHeader($name)
    {
        return $this->response->getHeader($name);
    }

    public function getHeaderLine($name)
    {
        return $this->response->getHeaderLine($name);
    }

    public function withHeader($name, $value)
    {
        return $this->response->withHeader($name, $value);
    }

    public function withAddedHeader($name, $value)
    {
        return $this->response->withAddedHeader($name, $value);
    }

    public function withoutHeader($name)
    {
        return $this->response->withoutHeader($name);
    }

    public function withBody(StreamInterface $body)
    {
        return $this->response->withBody($body);
    }

    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        return $this->response->withStatus($code, $reasonPhrase);
    }

    public function getReasonPhrase()
    {
        return $this->response->getReasonPhrase();
    }
}