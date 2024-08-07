<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Client;

final readonly class FailResult
{
    public function __construct(
        public Request $request,
        public Response $response,
    ) {
    }
}
