<?php

namespace Starteed\Responses;

use Psr\Http\Message\StreamInterface as StreamInterface;
use Psr\Http\Message\ResponseInterface as ResponseInterface;

class JWTResponse implements ResponseInterface
{
    /**
     * ResponseInterface to be wrapped by JWTResponse
     *
     * @var ResponseInterface
     */
    private $_response;

    /**
     * The body response
     */
    protected $body;

    /**
     * Set up the response to be wrapped
     *
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->_response = $response;
        $this->body = $this->_response->getBody();
        $this->token = json_decode( $this->body->__toString() )->token;
    }

    /**
     * Returns the body
     *
     * @return array $body - the json decoded body from the http response
     */
    public function getBody()
    {
        return json_decode($this->body->__toString(), true);
    }

    public function getPayload()
    {
        $jwt = static::decodeJWT($this->token);
        return static::parsePayload($jwt);
    }

    public static function decodeJWT($token)
    {
        return array_map(function($item) {
            return json_decode( base64_decode($item) ) ?: base64_decode($item);

        }, explode('.', $token));
    }

    public static function parsePayload(array $token)
    {
        return (object) [
            'header' => $token[0],
            'payload' => $token[1],
            'signature' => $token[2]
        ];
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