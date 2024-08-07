<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Tests;

use Anktx\Cloud\Dns\Client\CloudDnsApi;
use Anktx\Cloud\Dns\Client\Method\Authenticate\AuthenticationRequest;
use Anktx\Cloud\Dns\Client\Method\Authenticate\Token;

final class CloudDnsApiTest extends StubApi
{
    public function testRequest(): void
    {
        $api = $this->createApiFromArray($this->tokenArray());

        $response = $api->request(new AuthenticationRequest('client_id', 'client_secret'));

        $this->assertInstanceOf(Token::class, $response);
    }

    public function testBuildBody(): void
    {
        $this->expectException(\RuntimeException::class);

        CloudDnsApi::createResponseFromJson('not-a-json', Token::class);
    }
}
