<?php

namespace Remake\UDSConnector\Methods;

use \DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Базовый метод для моделей
 * Наследует Базовый Интерфейс
 * @package Remake\UDSConnector\Methods
 */
class BaseMethod implements Base {

    public const UDS_ENDPOINT = 'https://api.uds.app/partner/v2/';

    protected $response;

    public $methodPath;

    public function __construct($token)
    {
        $date = new DateTime();

        $client = new Client([
            'base_uri' => self::UDS_ENDPOINT,
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Charset' => 'utf-8',
                'Authorization' => 'Basic ' . $token,
                'X-Timestamp' => $date->format(DateTime::ATOM)
            ]
        ]);

        try {
            $this->response = $client->request('GET', $this->methodPath);
        } catch (RequestException $e) {
            $this->response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }
}