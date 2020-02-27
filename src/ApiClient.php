<?php
/**
 * *
 *  * @author Nikita Burakov <i@toshiyoung.com>
 *  * Copyright (c) 2020.
 *
 */

namespace Remake\UDSConnector;

use \DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

interface ClientInterface
{
    public function addPath($id);
    public function setToken($token);

    public function get($params);
    public function post($params);
    public function put($params);

    public function asArray(): array;
    public function asObject(): object;
    public function asJson();
}

abstract class ApiClient implements ClientInterface
{
    public const UDS_ENDPOINT = 'https://api.uds.app/partner/v2/';

    protected $response;
    protected $methodPath;

    public $addPath;
    public $token;

    public function setToken($token): ApiClient
    {
        $this->token = $token;
        return $this;
    }

    public function addPath($path) {
        $this->addPath = $path;
        return $this;
    }

    private function _request($methodType = 'GET', $params = []) {
        $date = new DateTime();

        $client = new Client([
            'base_uri' => self::UDS_ENDPOINT,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Accept-Charset' => 'utf-8',
                'Authorization' => 'Basic ' . $this->token,
                'X-Timestamp' => $date->format(DateTime::ATOM)
            ]
        ]);

        try {
            $responseClient = $client->request($methodType, $this->methodPath.'/'.$this->addPath, $params);

            if($responseClient->getBody()) {
                $this->response = json_decode($responseClient->getBody()->getContents());
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
                    'message' => $e->getMessage(),
                ];
            }
        }

        return $this->response;
    }

    public function get($params = []) {
        $this->_request('GET', ['query' => $params]);
        return $this;
    }

    public function post($params = [])
    {
        $this->_request('POST', ['body' => json_encode($params)]);
        return $this;
    }

    public function put($params = [])
    {
        $this->response = ['method' => 'put', 'path' => $this->methodPath, 'token' => $this->token];
        return $this;
    }

    final public function asArray(): array
    {
        return (array) $this->response;
    }

    final public function asObject(): object
    {
        return (object) $this->response;
    }

    final public function asJson() {
        return json_encode($this->response);
    }
}