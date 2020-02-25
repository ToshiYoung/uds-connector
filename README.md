# In Progress!

# UDS Connector Class


## About

A (wrapper)library to communicate with UDS Partner Api 2.

## Documentation
Генерация Токена
```
$token = UDSConnector::generateToken(COMPANY_ID, COMPANY_API_KEY);
```

По умолчанию отве приходит в виде Object. Но можно использователь методы asArray() и asJson()
```
$settings = UDSConnector::client($token)->api('operations')->asArray();
$settings = UDSConnector::client($token)->api('operations')->asJson();
```

Получение настроек компании
```
$settings = UDSConnector::client($token)->api('settings');
```

Список операций
```
$settings = UDSConnector::client($token)->api('operations');
```

Проведение операции
```
$settings = UDSConnector::client($token)->api('operations')->send([
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
