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
                $this->recordArray(),
            ],
        ]);

        $records = $api->getRecords('zoneId');

        $this->assertInstanceOf(Records::class, $records);
    }

    public function testGetRecord(): void
    {
        $api = $this->createApiFromArray($this->recordArray());

        $record = $api->getRecord('id', RecordType::MX, 'name');

        $this->assertInstanceOf(Record::class, $record);
    }

    public function testCreateRecord(): void
    {
        $api = $this->createApiFromArray($this->recordArray());

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
        $api = $this->createApiFromArray($this->recordArray());

        $rst = $api->deleteRecord('id', RecordType::MX, 'name');

        $this->assertTrue($rst);
    }

    /**
     * @return array<string, mixed>
     */
    public function recordArray(): array
    {
        return [
            'zone_id' => 'id',
            'name' => 'name',
            'type' => 'MX',
            'values' => ['value1', 'value2'],
            'ttl' => 3600,
            'enables' => true,
            'readonly' => true,
        ];
    }
}
