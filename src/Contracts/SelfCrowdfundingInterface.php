<?php

namespace Starteed\Contracts;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;

interface SelfCrowdfundingInterface
{
    /**
     * @param $name
     * @param $event
     *
     * @return mixed
     */
    public static function dispatch($name, $event);

    /**
     * @return mixed
     */
    public static function getDispatcher();

    public function request($method = 'GET', $uri = '', $payload = [], $headers = []);

    /**
     * @param \Http\Client\HttpClient $httpClient
     */
    public function setHttpClient(HttpClient $httpClient);

    /**
     * @return \Http\Message\RequestFactory
     */
    public function getMessageFactory();

    /**
     * @param \Http\Message\RequestFactory $messageFactory
     */
    public function setMessageFactory(RequestFactory $messageFactory);

    /**
     * @param string $key
     */
    public function login(string $key);

    /**
     * @return string
     */
    public static function getAuthToken();

    /**
     * @param string $jwt
     */
    public static function setAuthToken(string $jwt);
}