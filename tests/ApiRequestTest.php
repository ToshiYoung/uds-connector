<?php

namespace Remake\UDSConnector\Tests;

use Remake\UDSConnector\Connector;
use Remake\UDSConnector\Api\UDSOperations;
use Remake\UDSConnector\Api\UDSSettings;

use PHPUnit\Framework\TestCase;

class ApiRequestTest extends TestCase
{
    protected $client;

    protected $apiID = '';
    protected $apiKey = '';
    protected $testMobile = '';
    protected $testID = '';

    protected $operationId;

    /**
     * Настройка экземпляра коннектора
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->client = new Connector($this->apiID, $this->apiKey);
    }

    /**
     * Тест получения настроек компании https://api.uds.app/partner/v2/settings
     */
    public function testGetSettings(): void
    {
        $settings = $this->client->api(new UDSSettings)->get();

        $this->assertIsObject($settings->asObject());
        $this->assertArrayHasKey('id', $settings->asArray());
        $this->assertJson($settings->asJson());
    }

    public function testGetOperationsWithParams(): void
    {
        $rowCount = 4;
        $operation = $this->client->api(new UDSOperations)->get(['max' => $rowCount, 'offset' => 0]);
        $operationsArray = $operation->asArray();

        $this->assertIsObject($operation->asObject());
        $this->assertIsArray($operationsArray);

        $this->assertCount($rowCount, $operationsArray['rows']);
    }

    public function testCreateOperation() {
        $total = 100.0;
        $data = [
            'participant' => [
                'phone' => $this->testMobile
            ],
            'receipt' => [
                'total' => $total,
                'cash' => 100.0,
                'points' => 0.0
            ]
        ];

        $operation = $this->client->api(new UDSOperations)->post($data);
        $operationId = $operation->asObject()->id;

        $this->assertIsObject($operation->asObject());
        $this->assertIsArray($operation->asArray());
        $this->assertArrayHasKey('id', $operation->asArray());
        $this->assertArrayHasKey('total', $operation->asArray());
        $this->assertArrayHasKey('cash', $operation->asArray());

        $this->assertEquals($total, $operation->asObject()->total);

        return $operationId;
    }

    /**
     * @depends testCreateOperation
     */

    public function testGetOperationById(int $operationID) {

        $operation = $this->client->api(new UDSOperations)->addPath($operationID)->get();

        $this->assertIsArray($operation->asArray());
        $this->assertArrayHasKey('id', $operation->asArray());

        $this->assertEquals($operationID, $operation->asObject()->id);
    }

    /**
     * @depends testCreateOperation
     */

    public function testPartialRefundOperationById(int $operationID) {
        $refundSum = 30;

        $operation = $this->client->api(new UDSOperations)->addPath($operationID)->refund($refundSum);
        $this->assertIsArray($operation->asArray());
        $this->assertArrayHasKey('id', $operation->asArray());

        $this->assertEquals($operationID, $operation->asObject()->origin->id);
        $this->assertEquals($refundSum * -1, $operation->asObject()->total);
    }

    public function testTransactionCalc() {
        $data = [
            'participant' => [
                'phone' => $this->testMobile
            ],
            'receipt' => [
                'total' => 1000,
                'cash' => 1000,
                'points' => 0
            ]
        ];

        $operation = $this->client->api(new UDSOperations)->calc($data);

        $this->assertIsArray($operation->asArray());
        $this->assertArrayHasKey('id', $operation->asArray());
    }

    public function testReward() {
        $data = [
            'comment' => 'Подарок ТЕСТ',
            'points' => 50.0,
            'participants' => [
                $this->testID
            ]
        ];

        $operation = $this->client->api(new UDSOperations)->reward($data);
        /**
         * @todo Проверить
         */
        $this->assertArrayHasKey('accepted', $operation->asArray());
    }
}