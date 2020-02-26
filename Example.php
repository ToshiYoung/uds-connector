<?php
/**
 * *
 *  * @author Nikita Burakov <i@toshiyoung.com>
 *  * Copyright (c) 2020.
 *
 */

require_once 'vendor/autoload.php';

use Remake\UDSConnector\Methods\Settings;
use Remake\UDSConnector\Connector;

$apiId = '';
$apiKey = '';

$settings = (new Connector($apiId, $apiKey))
    ->api(new Settings)
    ->get()
    ->asArray();

$operation = (new Connector($apiId, $apiKey))
    ->api(new Settings)
    ->get(['max' => 10, 'offset' => 9])
    ->asArray();
