<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Records;

use Anktx\Cloud\Dns\Client\Client\HttpMethod;
use Anktx\Cloud\Dns\Client\Client\Request;
use Anktx\Cloud\Dns\Client\Method\TrueValue;

final readonly class DeleteRecordRequest implements Request
{
    public function __construct(
        private string $zoneId,
        private RecordType $type,
        private string $name,
    ) {
    }

    public function method(): HttpMethod
    {
        return HttpMethod::DELETE;
    }

    public function url(): string
    {
        return 'clouddns/v1/zones/' . $this->zoneId . '/records/' . $this->name . '/' . $this->type->name;
    }

    public function data(): array
    {
        return [];
    }

    public function resultType(): string
    {
        return TrueValue::class;
    }
}
