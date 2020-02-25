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
class Connector {

    /**
     * Access Token
     * @var string
     */
    private $token;

    /**
     * Connector constructor.
     * @param $apiId
     * @param $apiKey
     */
    public function __construct($apiId, $apiKey)
    {
        $this->token = base64_encode("$apiId:$$apiKey");
    }

    /**
     * Загрузка метода API
     * @example $client->api('settings')
     * @param $method
     * @return object
     */
    public function api($method): object
    {
        $class = "Remake\UDSConnector\Methods\\".ucfirst($method);

        if(!class_exists($class)) {
            return (object) [
                'error' => "Метод $method не описан",
            ];
        }

        return new $class($this->token);
    }
}