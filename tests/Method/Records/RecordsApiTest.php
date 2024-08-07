<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Tests\Method\Records;

use Anktx\Cloud\Dns\Client\Method\Records\Record;
use Anktx\Cloud\Dns\Client\Method\Records\Records;
use Anktx\Cloud\Dns\Client\Method\Records\RecordType;
use Anktx\Cloud\Dns\Client\Tests\StubApi;

final class RecordsApiTest extends StubApi
{
    public function testGetRecords(): void
    {
        $api = $this->createApiFromArray([
            'items' => [
                [
                    'zone_id' => 'id',
                    'name' => 'name',
                    'type' => 'MX',
                    'values' => ['value1', 'value2'],
                    'ttl' => 3600,
                    'enables' => true,
                    'readonly' => true,
                ],
            ],
        ]);

        $records = $api->getRecords('zoneId');

        $this->assertInstanceOf(Records::class, $records);
    }

    public function testGetRecord(): void
    {
        $api = $this->createApiFromArray([
            'zone_id' => 'id',
            'name' => 'name',
            'type' => 'MX',
            'values' => ['value1', 'value2'],
            'ttl' => 3600,
            'enables' => true,
            'readonly' => true,
        ]);

        $record = $api->getRecord('id', RecordType::MX, 'name');

        $this->assertInstanceOf(Record::class, $record);
    }

    public function testCreateRecord(): void
    {
        $api = $this->createApiFromArray([
            'zone_id' => 'id',
            'name' => 'name',
            'type' => 'MX',
            'values' => ['value1', 'value2'],
            'ttl' => 3600,
            'enables' => true,
            'readonly' => true,
        ]);

        $record = $api->createRecord(
            'id',
            RecordType::MX,
            'name',
            3600,
            ['value1', 'value2'],
        );

        $this->assertInstanceOf(Record::class, $record);
    }

    public function testDeleteRecord(): void
    {
        $api = $this->createApiFromArray([
            'zone_id' => 'id',
            'name' => 'name',
            'type' => 'MX',
            'values' => ['value1', 'value2'],
            'ttl' => 3600,
            'enables' => true,
            'readonly' => true,
        ]);

        $rst = $api->deleteRecord('id', RecordType::MX, 'name');

        $this->assertTrue($rst);
    }
}
