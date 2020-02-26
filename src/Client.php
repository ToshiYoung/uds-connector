<?php
/**
 * *
 *  * @author Nikita Burakov <i@toshiyoung.com>
 *  * Copyright (c) 2020.
 *
 */

namespace Remake\UDSConnector;

interface ClientInterface
{
    public function setToken($token);

    public function get($params);
    public function post($params);
    public function put($params);

    public function asArray(): array;
    public function asObject(): object;
    public function asJson();
}

abstract class Client implements ClientInterface
{
    protected $response;
    protected $methodPath;
    public $token;

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    public function get($params = []) {
        $this->response = ['method' => 'get', 'path' => $this->methodPath, 'token' => $this->token, 'params' => $params];
        return $this;
    }

    public function post($params = []) {
        $this->response = ['method' => 'post', 'path' => $this->methodPath, 'token' => $this->token];
        return $this;
    }

    public function put($params = []) {
        $this->response = ['method' => 'put', 'path' => $this->methodPath, 'token' => $this->token];
        return $this;
    }

    final public function asArray(): array
    {
        return (array) $this->response;
    }

    final public function asObject(): object {
        return (object) $this->response;
    }

    final public function asJson() {
        return $this->request();
    }
}