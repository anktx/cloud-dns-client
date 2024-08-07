<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Authenticate;

final readonly class Token
{
    public function __construct(
        public string $accessToken,
        public string $idToken,
        public \DateTimeImmutable $expiresIn,
        public string $scope,
        public string $tokenType,
    ) {
    }

    public static function create(\stdClass $std): self
    {
        $expiresIn = \DateTimeImmutable::createFromFormat('U', (string) (time() + $std->expires_in), new \DateTimeZone('UTC'));

        return new self(
            accessToken: $std->access_token,
            idToken: $std->id_token,
            expiresIn: $expiresIn,
            scope: $std->scope,
            tokenType: $std->token_type,
        );
    }

    public function isExpired(\DateTimeImmutable $when): bool
    {
        return $this->expiresIn < $when;
    }
}
