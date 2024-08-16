<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Client;

final readonly class Response
{
    public function __construct(
        public string $body,
        public int $httpCode,
    ) {}
}
