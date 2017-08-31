<?php

namespace Starteed\Responses;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;

class JWTResponse implements ResponseInterface
{
    /**
     * ResponseInterface to be wrapped by JWTResponse
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * The body response
     */
    protected $body;

    /**
     * @var string
     */
    protected $token;

    /**
     * Set up the response to be wrapped
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        $this->body = $this->response->getBody();
        $this->token = json_decode($this->body->__toString())->token;
    }

    /**
     * Returns the body
     *
     * @return array $body Decoded JSON body from HttpResponse
     */
    public function getBody()
    {
        return json_decode($this->body->__toString(), true);
    }

    /**
     * @return static
     */
    public function getPayload()
    {
        $jwt = static::decodeJWT($this->token);
        return static::parsePayload($jwt);
    }

    /**
     * @param string $token
     *
     * @return array
     */
    public static function decodeJWT(string $token)
    {
        return array_map(function($item) {
            return json_decode(base64_decode($item)) ?: base64_decode($item);
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