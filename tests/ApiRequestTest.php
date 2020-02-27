<?php

namespace Remake\UDSConnector\Tests;

use Remake\UDSConnector\Connector;
use Remake\UDSConnector\Methods\Operations;
use Remake\UDSConnector\Methods\Settings;

use PHPUnit\Framework\TestCase;

class ApiRequestTest extends TestCase
{
    protected $client;

    protected $apiID = '549755819292';
    protected $apiKey = 'OTkwMTA4MjEtZDk4MS00M2Y4LThmYzEtMWZiOGQ1OWFlYjIy';
    protected $testMobile = '+79301579978';
    protected $testID = '135837205';

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
    public function testGetSettings() {
        $settings = $this->client->api(new Settings)->get();

        $this->assertIsObject($settings->asObject());
        $this->assertArrayHasKey('id', $settings->asArray());
        $this->assertJson($settings->asJson());
    }

    public function testGetOperationsWithParams() {
        $rowCount = 4;
        $operation = $this->client->api(new Operations)->get(['max' => $rowCount, 'offset' => 0]);
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

        $operation = $this->client->api(new Operations)->post($data);
        print_r($operation);
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

        $operation = $this->client->api(new Operations)->addPath($operationID)->get();

        $this->assertIsArray($operation->asArray());
        $this->assertArrayHasKey('id', $operation->asArray());

        $this->assertEquals($operationID, $operation->asObject()->id);
    }

    /**
     * @depends testCreateOperation
     */

    public function testPartialRefundOperationById(int $operationID) {
        $refundSum = 30;

        $operation = $this->client->api(new Operations)->addPath($operationID)->refund($refundSum);
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

        $operation = $this->client->api(new Operations)->calc($data);

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

        $operation = $this->client->api(new Operations)->reward($data);

        print_r($operation);
    }
}