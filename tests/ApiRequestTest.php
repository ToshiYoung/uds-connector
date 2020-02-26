<?php

namespace Remake\UDSConnector\Tests;

use Remake\UDSConnector\Connector;
use PHPUnit\Framework\TestCase;

class ApiRequestTest extends TestCase
{
    protected $connector;

    /**
     * Настройка экземпляра коннектора
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->connector = new Connector('', '');
    }

    /**
     * Тест получения настроек компании https://api.uds.app/partner/v2/settings
     */
    public function testGetSettings() {
        $api = $this->connector->api('settings');

        $this->assertIsObject($api->asObject());
        $this->assertIsArray($api->asArray());

        $this->assertArrayHasKey('name', $api->asArray());
    }
}