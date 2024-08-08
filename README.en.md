# Cloud.ru DNS API client

[![Latest Stable Version](https://poser.pugx.org/anktx/cloud-dns-client/v)](https://packagist.org/packages/anktx/cloud-dns-client)
[![Total Downloads](https://poser.pugx.org/anktx/cloud-dns-client/downloads)](https://packagist.org/packages/anktx/cloud-dns-client)

The package provides a PHP wrapper to interact with the Cloud.ru DNS API.

## Requirements

- PHP 8.2 or higher.

## Installation

```shell
composer require anktx/cloud-dns-client
```

## General usage

To interact with the [Cloud.ru DNS API](https://cloud.ru/docs/clouddns/ug/topics/api-ref.html),
you need to create an instance of the `CloudDnsApi` class. This class requires a
[PSR-18](https://www.php-fig.org/psr/psr-18/) `ClientInterface` implementation and `HttpAdapter`,
which in turn requires [PSR-17](https://www.php-fig.org/psr/psr-17/) `RequestFactoryInterface`
and `StreamFactoryInterface`.

You can use the [kriswallsmith/buzz](https://github.com/kriswallsmith/Buzz) and [nyholm/psr7](https://github.com/Nyholm/psr7) packages for this:

```shell
composer require kriswallsmith/buzz nyholm/psr7
```

Here's now you can create an instance of `CloudDnsApi`:

```php
use Anktx\Cloud\Dns\Client\Client\HttpAdapter;
use Anktx\Cloud\Dns\Client\CloudDnsApi;
use Buzz\Client\Curl;
use Nyholm\Psr7\Factory\Psr17Factory;

// Dependencies
$psr17Factory = new Psr17Factory();
$httpAdapter = new HttpAdapter($psr17Factory, $psr17Factory);
$httpClient = new Curl($psr17Factory);

// API
$api = new CloudDnsApi(
    client: $httpClient,
    httpAdapter: $httpAdapter,
);
```

First, obtain an authentication token and pass it to `HttpAdapter`:
```php
$token = $api->authenticate('CLIENT_ID', 'CLIENT_SECRET');
$httpAdapter->setToken($token);
```

Now you can use the `$api` instance to interact with the Cloud.ru DNS API.

```php
// Get zones
$api->getZones('PROJECT_ID');

// Create zone
$api->createZone('New zone', 'PROJECT_ID');
```

The result will be either `FailResult` instance (on error) or an object of the corresponding type (on success). For example:

```php
// Result is a collection of `Record` objects
$records = $api->getRecords('ZONE_ID');

foreach ($records as $record) {
    echo 'name: ' . $record->name . ' ttl: ' . $record->ttl . \PHP_EOL;
}
```
