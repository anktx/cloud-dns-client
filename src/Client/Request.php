<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Client;

interface Request
{
    public function method(): HttpMethod;

    public function url(): string;

    /**
     * @return array<string, mixed>
     */
    public function data(): array;

    public function resultType(): string;
}
