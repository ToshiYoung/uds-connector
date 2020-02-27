<?php
/**
 * *
 *  * @author Nikita Burakov <i@toshiyoung.com>
 *  * Copyright (c) 2020.
 *
 */

namespace Remake\UDSConnector\Api;

Class UDSOperations extends UDSClient {
    protected $methodPath = 'operations';

    public function refund($partial = null) {
        $this->addPath($this->addPath.'/refund');

        $params = $partial === null ? [] : [
            'partialAmount' => (double) $partial
        ];

        return $this->post($params);
    }

    public function calc($data) {
        return $this->post($data);
    }

    public function reward($data) {
        $this->addPath('reward');
        return $this->post($data);
    }
}