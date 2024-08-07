<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Tests\Method\Authenticate;

use Anktx\Cloud\Dns\Client\Method\Authenticate\Token;
use Anktx\Cloud\Dns\Client\Tests\StubApi;

final class AuthenticateApiTest extends StubApi
{
    public function testAuthenticate(): void
    {
        $api = $this->createApiFromArray($this->tokenArray());

        $rst = $api->authenticate('clientId', 'clientSecret');

        $this->assertInstanceOf(Token::class, $rst);
    }
}
