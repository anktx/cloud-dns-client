<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Authenticate;

use Anktx\Cloud\Dns\Client\Client\HttpMethod;
use Anktx\Cloud\Dns\Client\Client\Request;

final readonly class AuthenticationRequest implements Request
{
    public function __construct(
        private string $clientId,
        private string $clientSecret,
    ) {}

    public function method(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function url(): string
    {
        return 'https://auth.iam.sbercloud.ru/auth/system/openid/token';
    }

    public function data(): array
    {
        return [
            'grant_type' => 'access_key',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];
    }

    public function resultType(): string
    {
        return Token::class;
    }
}
