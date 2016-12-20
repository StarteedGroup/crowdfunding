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
    private $_response;

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
        $this->_response = $response;
        // create the ResponseEvent and dispatching it
        $event = new ResponseEvent($this->_response);
        Crowdfunding::dispatch(ResponseEvent::NAME, $event);
    }

    /**
     * Returns the body
     *
     * @return array $body - the json decoded body from the http response
     */
    public function getBody()
    {
        $body = $this->_response->getBody();
        $body_string = $body->__toString();
        $json = json_decode($body_string, true);
        return $json;
    }

    /**
     * Pass these down to the response given in the constructor
     */
    public function getProtocolVersion()
    {
        return $this->_response->getProtocolVersion();
    }

    public function withProtocolVersion($version)
    {
        return $this->_response->withProtocolVersion($version);
    }

    public function getHeaders()
    {
        return $this->_response->getHeaders();
    }

    public function hasHeader($name)
    {
        return $this->_response->hasHeader($name);
    }

    public function getHeader($name)
    {
        return $this->_response->getHeader($name);
    }

    public function getHeaderLine($name)
    {
        return $this->_response->getHeaderLine($name);
    }

    public function withHeader($name, $value)
    {
        return $this->_response->withHeader($name, $value);
    }

    public function withAddedHeader($name, $value)
    {
        return $this->_response->withAddedHeader($name, $value);
    }

    public function withoutHeader($name)
    {
        return $this->_response->withoutHeader($name);
    }

    public function withBody(StreamInterface $body)
    {
        return $this->_response->withBody($body);
    }

    public function getStatusCode()
    {
        return $this->_response->getStatusCode();
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        return $this->_response->withStatus($code, $reasonPhrase);
    }

    public function getReasonPhrase()
    {
        return $this->_response->getReasonPhrase();
    }
}