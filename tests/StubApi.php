<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Tests;

use Anktx\Cloud\Dns\Client\Client\HttpAdapter;
use Anktx\Cloud\Dns\Client\CloudDnsApi;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

abstract class StubApi extends TestCase
{
    /**
     * @param array<string, mixed> $arr
     */
    final protected function createApiFromArray(array $arr, int $httpCode = 200): CloudDnsApi
    {
        return $this->createApi(json_encode($arr), $httpCode);
    }

    /**
     * @return array<string, mixed>
     */
    final protected function tokenArray(string $token = 'access_token', int $ttl = 3600): array
    {
        return [
            'access_token' => $token,
            'id_token' => 'id_token',
            'scope' => 'scope',
            'token_type' => 'token_type',
            'expires_in' => $ttl,
        ];
    }

    final protected function createHttpAdapter(): HttpAdapter
    {
        $psr17Factory = new Psr17Factory();

        return new HttpAdapter($psr17Factory, $psr17Factory);
    }

    private function createApi(string $body, int $httpCode = 200): CloudDnsApi
    {
        $psr17Factory = new Psr17Factory();

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($psr17Factory->createStream($body));
        $responseMock->method('getStatusCode')->willReturn($httpCode);

        $clientMock = $this->createMock(ClientInterface::class);
        $clientMock->method('sendRequest')->willReturn($responseMock);

        return new CloudDnsApi(
            client: $clientMock,
            httpAdapter: $this->createHttpAdapter(),
        );
    }
}
