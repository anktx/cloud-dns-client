<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Tests\Method\Zones;

use Anktx\Cloud\Dns\Client\Method\Zones\Zones;
use PHPUnit\Framework\TestCase;

final class ZonesTest extends TestCase
{
    public function testOffsetSetException(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $zones = new Zones();
        $zones[0] = $this->zoneObject();
    }

    public function testOffsetUnsetException(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $zones = new Zones();
        unset($zones[0]);
    }

    private function zoneObject(): \stdClass
    {
        return (object) [
            'id' => 'zone-id',
            'name' => 'zone-name',
            'type' => 'zone-type',
            'ttl' => 3600,
            'records' => [],
        ];
    }
}
