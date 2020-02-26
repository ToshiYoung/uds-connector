<?php

namespace Remake\UDSConnector\Tests;

use Remake\UDSConnector\Connector;
use Remake\UDSConnector\Methods\Operations;
use Remake\UDSConnector\Methods\Settings;

use PHPUnit\Framework\TestCase;

class ApiRequestTest extends TestCase
{
    protected $client;

    /**
     * Настройка экземпляра коннектора
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->client = new Connector('asd', 'asd');
    }

    /**
     * Тест получения настроек компании https://api.uds.app/partner/v2/settings
     */
    public function testGetSettings() {
        $settings = $this->client->api(new Settings)->get();

        $this->assertIsObject($settings->asObject());

        $this->assertIsArray(
            (new Connector('asd', 'asd'))
                ->api(new Settings)
                ->get()
                ->asArray()
        );
    }

    public function testGetOperationsWithParams() {
        $operation = $this->client->api(new Operations)->get(['max' => 10, 'offset' => 2]);

        $this->assertIsObject($operation->asObject());
        $this->assertIsArray($operation->asArray());
    }
}