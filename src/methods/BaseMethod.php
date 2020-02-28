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
            $response = $client->request('GET', $this->methodPath);
            if($response->getBody()) {
                $this->response = json_decode($response->getBody()->getContents());
            }

        } catch (RequestException $e) {
            if($e->getCode() === 401) {
                $this->response = [
                    'code' => $e->getCode(),
                    'message' => 'Проверьте правильность COMPANY_ID и API_KEY'
                ];
            } else {
                $this->response = [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ];
            }
        }
    }

    public function asObject() {
        return (object) $this->response;
    }

    public function asArray() {
        return (array) $this->response;
    }
}