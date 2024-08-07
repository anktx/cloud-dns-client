<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Records;

use Anktx\Cloud\Dns\Client\Client\HttpMethod;
use Anktx\Cloud\Dns\Client\Client\Request;

final readonly class GetRecordsRequest implements Request
{
    public function __construct(
        private string $zoneId,
    ) {
    }

    public function method(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function url(): string
    {
        return 'clouddns/v1/zones/' . $this->zoneId . '/records';
    }

    public function data(): array
    {
        return [];
    }

    public function resultType(): string
    {
        return Records::class;
    }
}
