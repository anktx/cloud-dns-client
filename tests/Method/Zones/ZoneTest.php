<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Tests\Method\Zones;

use Anktx\Cloud\Dns\Client\Method\Zones\Zone;
use Anktx\Cloud\Dns\Client\Method\Zones\Zones;
use PHPUnit\Framework\TestCase;

final class ZoneTest extends TestCase
{
    public function testZonesCreate(): void
    {
        $zones = Zones::create((object) [
            'items' => [
                $this->zoneObject(),
                $this->zoneObject(),
                $this->zoneObject(),
            ],
        ]);

        $this->assertCount(3, $zones);
        $this->assertContainsOnlyInstancesOf(Zone::class, $zones);
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
