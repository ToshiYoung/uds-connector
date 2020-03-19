<?php
/**
 * @author Nikita Burakov <i@toshiyoung.com>
 * Copyright (c) 2020
 */

namespace Remake\UDSConnector;

/**
 * Class Connector
 * @package Remake\UDSConnector
 */
class Connector
{
    private $method;
    private $token;

    protected $response;

    public function __construct($apiId, $apiKey)
    {
        $this->token = base64_encode("$apiId:$apiKey");
    }

    public function api($method)
    {
        $this->method = $method;
        $this->method->setToken($this->token);

        return $this->method;
    }
}