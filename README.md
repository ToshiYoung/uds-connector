# In Progress!

# UDS Connector Class


## About

A (wrapper)library to communicate with UDS Partner Api 2.

## Documentation
Инициализация подключения

```
use Remake\UDSConnector\Connector;

$UDSClient = new Connector($company_id, $api_key);
$result = $UDSClient->api(ИМЯ_МЕТОДА);
```

Для вывода результата используется
```
//В виде Объекта
$settings = $result->asObject();

//В виде Ассоциативного массива
$settings = $result->asArray();
```

Получение настроек компании
```
$settings = UDSConnector::client($token)->api('settings');
var_dump($settings->assArray());
```

Список операций
```
$settings = UDSConnector::client($token)->api('operations');
```

Проведение операции
```
$settings = UDSConnector::client($token)->api('operations')->post([
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
