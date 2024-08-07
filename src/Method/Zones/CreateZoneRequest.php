<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Zones;

use Anktx\Cloud\Dns\Client\Client\HttpMethod;
use Anktx\Cloud\Dns\Client\Client\Request;

final readonly class CreateZoneRequest implements Request
{
    public function __construct(
        private string $name,
        private string $parentId,
    ) {
    }

    public function method(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function url(): string
    {
        return 'clouddns/v1/zones';
    }

    public function data(): array
    {
        return [
            'name' => $this->name,
            'parentId' => $this->parentId,
        ];
    }

    public function resultType(): string
    {
        return Zone::class;
    }
}
