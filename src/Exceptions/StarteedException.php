<?php

namespace Starteed\Exceptions;

use Exception;
use Http\Client\Exception\HttpException;

class StarteedException extends Exception
{
    /**
     * Variable to hold json decoded body from http response.
     *
     * @var array Body from the response
     */
    protected $body = null;

    /**
     * Sets up the custom exception and copies over original exception values.
     *
     * @param Exception $exception - the exception to be wrapped
     */
    public function __construct(Exception $exception)
    {
        $message = json_decode( $exception->getResponse()->getBody()->__toString() );
        $code = $exception->getCode();
        if ($exception instanceof HttpException) {
            $code = $message->status_code;
            if (property_exists($message, 'errors')) {
                $message = $this->body = implode(', ', array_keys( (array) $message->errors) );

            } else {
                $message = $this->body = $message->message;
                
            }
        }

        parent::__construct($message, $code, $exception->getPrevious());
    }

    /**
     * Returns the body.
     *
     * @return array $body - the json decoded body from the http response
     */
    public function getBody()
    {
        return $this->body;
    }
}