<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Tests;

use Anktx\Cloud\Dns\Client\Client\HttpAdapter;
use Anktx\Cloud\Dns\Client\CloudDnsApi;
use Anktx\Cloud\Dns\Client\Method\Authenticate\Token;
use Buzz\Client\Curl;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('realApi')]
final class CloudDnsApiRealTest extends TestCase
{
    public function testAuthenticate(): void
    {
        $psr17Factory = new Psr17Factory();

        $adapter = new HttpAdapter($psr17Factory, $psr17Factory);
        $httpClient = new Curl($psr17Factory);

        $api = new CloudDnsApi(
            client: $httpClient,
            httpAdapter: $adapter
        );

        $token = $api->authenticate($_ENV['CLIENT_ID'], $_ENV['CLIENT_SECRET']);

        $this->assertInstanceOf(Token::class, $token);
    }
}
