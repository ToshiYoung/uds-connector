<?php

namespace Remake\UDSConnector\Tests;

use Remake\UDSConnector\Connector;
use PHPUnit\Framework\TestCase;

class ApiRequestTest extends TestCase
{
    protected $connector;

    public function setUp(): void
    {
        parent::setUp();
        $this->connector = new Connector('', '');
    }

    public function testGetSettings() {
        $api = $this->connector->api('settings');
        $this->assertIsObject($api);
    }
}