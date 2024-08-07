<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Tests\Method\Authenticate;

use Anktx\Cloud\Dns\Client\Method\Authenticate\Token;
use PHPUnit\Framework\TestCase;

final class TokenTest extends TestCase
{
    public function testIsNotExpired(): void
    {
        $ttl = mt_rand(0, 86400);

        $token = Token::create((object) [
            'access_token' => 'access_token',
            'id_token' => 'id_token',
            'scope' => 'scope',
            'token_type' => 'token_type',
            'expires_in' => $ttl,
        ]);

        $this->assertFalse($token->isExpired($this->getTtlDatetime($ttl - 1)));
        $this->assertFalse($token->isExpired($this->getTtlDatetime($ttl)));
        $this->assertTrue($token->isExpired($this->getTtlDatetime($ttl + 1)));
    }

    public function getTtlDatetime(int $ttl): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat('U', (string) (time() + $ttl));
    }
}
