<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Zones;

use Anktx\Cloud\Dns\Client\Client\HttpMethod;
use Anktx\Cloud\Dns\Client\Client\Request;

final readonly class GetZonesRequest implements Request
{
    public function __construct(
        private string $parentId,
    ) {
    }

    public function method(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function url(): string
    {
        return 'clouddns/v1/zones?parentId=' . $this->parentId;
    }

    public function data(): array
    {
        return [];
    }

    public function resultType(): string
    {
        return Zones::class;
    }
}
