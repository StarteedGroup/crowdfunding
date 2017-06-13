<?php

namespace Starteed\Exceptions;

use Http\Client\Exception\HttpException;

class StarteedException extends \Exception
{
    /**
     * Variable to hold json decoded body from HTTP Response.
     *
     * @var object Body from the response
     */
    protected $body;

    /**
     * @var string
     */
    protected $message;

    /**
     * Sets up the custom exception and copies over original exception values.
     *
     * @param \Http\Client\Exception\HttpException $exception The exception to be wrapped
     */
    public function __construct(HttpException $exception)
    {
        $this->body = json_decode($exception->getResponse()->getBody()->__toString());

        $this->message = property_exists($this->body, 'message') ? $this->body->message : null;
        $this->code = property_exists($this->body, 'code') ? $this->body->code : $exception->getCode();

        if (property_exists($this->message, 'errors')) {
            $errors = (array) $this->message->errors;
            $message = implode(', ', array_keys($errors));
        } else {
            $message = $this->body->message;
        }
        parent::__construct($message, $this->code, $exception->getPrevious());
    }
}
