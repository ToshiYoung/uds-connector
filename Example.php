<?php
/**
 * *
 *  * @author Nikita Burakov <i@toshiyoung.com>
 *  * Copyright (c) 2020.
 *
 */

require_once 'vendor/autoload.php';

use Remake\UDSConnector\Connector;

$apiId = '';
$apiKey = '';

$client = new Connector($apiId, $apiKey);

print_r($client->api('settings'));

