<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Zones;

use Anktx\Cloud\Dns\Client\Client\HttpMethod;
use Anktx\Cloud\Dns\Client\Client\Request;
use Anktx\Cloud\Dns\Client\Stuff\TrueValue;

final readonly class DeleteZoneRequest implements Request
{
    public function __construct(
        private string $id,
    ) {}

    public function method(): HttpMethod
    {
        return HttpMethod::DELETE;
    }

    public function url(): string
    {
        return 'clouddns/v1/zones/' . $this->id;
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
