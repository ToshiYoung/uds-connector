# UDS Connector Class (In Progress)


## About

A (wrapper)library to communicate with UDS Partner Api 2.

## Documentation
Инициализация подключения

```
use Remake\UDSConnector\Connector;

$UDSClient = new Connector($company_id, $api_key);
$result = $UDSClient->api(ИМЯ_МЕТОДА)->get();
```

Для вывода результата используется
```
//В виде Объекта
$settings = $result->asObject();

//В виде Ассоциативного массива
$settings = $result->asArray();

//В виде JSON строки
$settings = $result->asJson();

```

Получение настроек компании
```
use Remake\UDSConnector\Connector;
use Remake\UDSConnector\Api\UDSSettings;

$UDSClient = new Connector($company_id, $api_key);
$settings = $UDSClient->api(new UDSSettings)->get();
var_dump($settings->assArray());
```

Список операций
```
use Remake\UDSConnector\Connector;
use Remake\UDSConnector\Api\UDSOperations;

$UDSClient = new Connector($company_id, $api_key);
$settings = $UDSClient->api(new UDSOperations)->get();
```

Проведение операции
```
use Remake\UDSConnector\Connector;
use Remake\UDSConnector\Api\UDSOperations;

$UDSClient = new Connector($company_id, $api_key);

$operation = $UDSClient->api(new UDSOperations)->post([
    'code' => 'string',
    'participant' => [
      'uid' => 'string',
      'phone' => 'string'
    ],
    'nonce' => 'string',
    'cashier' => [
      'externalId' => 'string',
      'name' => 'string'
    ],
    'receipt' => [
      'total' => 100.0,
      'cash' => 50.0,
      'points' => 50.0,
      'number' => 'string',
      'skipLoyaltyTotal' => 50.0
    ]
]);

```
