<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Tests\Method\Zones;

use Anktx\Cloud\Dns\Client\Method\Zones\Zone;
use Anktx\Cloud\Dns\Client\Method\Zones\Zones;
use Anktx\Cloud\Dns\Client\Tests\StubApi;

final class ZonesApiTest extends StubApi
{
    public function testGetZones(): void
    {
        $api = $this->createApiFromArray([
            'items' => [
                $this->zoneArray(),
            ],
        ]);

        $zones = $api->getZones('parentId');

        $this->assertInstanceOf(Zones::class, $zones);
        $this->assertCount(1, $zones);
    }

    public function testGetZone(): void
    {
        $api = $this->createApiFromArray($this->zoneArray());

        $zone = $api->getZone('id');

        $this->assertInstanceOf(Zone::class, $zone);
        $this->assertEquals('id', $zone->id);
    }

    public function testCreateZone(): void
    {
        $api = $this->createApiFromArray($this->zoneArray());

        $zone = $api->createZone('name', 'parentId');

        $this->assertInstanceOf(Zone::class, $zone);
        $this->assertEquals('id', $zone->id);
    }

    public function testDeleteZone(): void
    {
        $api = $this->createApiFromArray($this->zoneArray());

        $rst = $api->deleteZone('id');

        $this->assertTrue($rst);
    }

    /**
     * @return array<string, mixed>
     */
    public function zoneArray(): array
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'parent_id' => 'parentId',
            'valid' => true,
            'validation_text' => 'validationText',
            'delegated' => true,
            'created_at' => '2022-01-01T00:00:00.000000Z',
            'updated_at' => '2022-01-01T00:00:00.000000Z',
        ];
    }
}
