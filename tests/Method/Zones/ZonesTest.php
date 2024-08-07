<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Tests\Method\Zones;

use Anktx\Cloud\Dns\Client\Method\Zones\Zone;
use Anktx\Cloud\Dns\Client\Method\Zones\Zones;
use PHPUnit\Framework\TestCase;

final class ZonesTest extends TestCase
{
    public function testOffsetSetException(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $zones = new Zones();
        $zones[0] = Zone::create($this->zoneObject());
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
            'id' => 'zone_id',
            'parent_id' => 'parent_id',
            'name' => 'zone name',
            'valid' => true,
            'validation_text' => 'validation text',
            'delegated' => true,
            'created_at' => '2020-01-01T00:00:00.000000Z',
            'updated_at' => '2020-01-01T00:00:00.000000Z',
        ];
    }
}
