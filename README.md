
### For english documentation see [README.en.md](README.en.md)

# Cloud.ru DNS API client

[![Latest Stable Version](https://poser.pugx.org/anktx/cloud-dns-client/v)](https://packagist.org/packages/anktx/cloud-dns-client)
[![Total Downloads](https://poser.pugx.org/anktx/cloud-dns-client/downloads)](https://packagist.org/packages/anktx/cloud-dns-client)

Пакет предоставляет PHP-обёртку для взаимодействия с API DNS Cloud.ru.

## Требования

- PHP 8.2 или выше.

## Установка

```shell
composer require anktx/cloud-dns-client
```

## Общие указания

Для ваимодействия [Cloud.ru DNS API](https://cloud.ru/docs/clouddns/ug/topics/api-ref.html),
необходимо создать экземпляр класса `CloudDnsApi`. Это класс требует реализацию интерфейса
[PSR-18](https://www.php-fig.org/psr/psr-18/) `ClientInterface` и `HttpAdapter`,
который в свою очередь требует реализации [PSR-17](https://www.php-fig.org/psr/psr-17/) `RequestFactoryInterface`
и `StreamFactoryInterface`.

Вы можете использовать пакеты [kriswallsmith/buzz](https://github.com/kriswallsmith/Buzz) и [nyholm/psr7](https://github.com/Nyholm/psr7) для этого:

```shell
composer require kriswallsmith/buzz nyholm/psr7
```

Вот как можно создать экзмепляр `CloudDnsApi`:

```php
use Anktx\Cloud\Dns\Client\Client\HttpAdapter;
use Anktx\Cloud\Dns\Client\CloudDnsApi;
use Buzz\Client\Curl;
use Nyholm\Psr7\Factory\Psr17Factory;

// Зависимости
$psr17Factory = new Psr17Factory();
$httpAdapter = new HttpAdapter($psr17Factory, $psr17Factory);
$httpClient = new Curl($psr17Factory);

// API
$api = new CloudDnsApi(
    client: $httpClient,
    httpAdapter: $httpAdapter,
);
```

Сначала получите токен аутентификации и передате его в `HttpAdapter`:
```php
$token = $api->authenticate('CLIENT_ID', 'CLIENT_SECRET');
$httpAdapter->setToken($token);
```

Теперь вы можете использовать экземпляр `$api` для взаимодействия с Cloud.ru DNS API.

```php
// Получение зон
$api->getZones('PROJECT_ID');

// Создание зоны
$api->createZone('New zone', 'PROJECT_ID');
```

Результат будет либо экземпляром `FailResult` (в случае ошибки), либо объектом соответствующего типа (в случае успеха). Например:

```php
// Результат - массив объектов `Record`
$records = $api->getRecords('ZONE_ID');

foreach ($records as $record) {
    echo 'name: ' . $record->name . ' ttl: ' . $record->ttl . \PHP_EOL;
}
```
