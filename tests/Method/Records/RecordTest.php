<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Tests\Method\Records;

use Anktx\Cloud\Dns\Client\Method\Records\Record;
use Anktx\Cloud\Dns\Client\Method\Records\Records;
use Anktx\Cloud\Dns\Client\Method\Records\RecordType;
use PHPUnit\Framework\TestCase;

final class RecordTest extends TestCase
{
    public function testCreateFromString(): void
    {
        $this->assertEquals(RecordType::A, RecordType::from('A'));
        $this->assertEquals(RecordType::CNAME, RecordType::from('CNAME'));
        $this->assertEquals(RecordType::MX, RecordType::from('MX'));
        $this->assertEquals(RecordType::TXT, RecordType::from('TXT'));
        $this->assertEquals(RecordType::SRV, RecordType::from('SRV'));
        $this->assertEquals(RecordType::NS, RecordType::from('NS'));
        $this->assertEquals(RecordType::SOA, RecordType::from('SOA'));
        $this->assertEquals(RecordType::AAAA, RecordType::from('AAAA'));
    }

    public function testTtlIsInteger(): void
    {
        $record = Record::create($this->recordObject());

        $this->assertEquals(3600, $record->ttl);
    }

    public function testRecordsOffsetGet(): void
    {
        $arr = [
            'items' => [
                $this->recordObject(),
                $this->recordObject(),
                $this->recordObject(),
            ],
        ];

        $records = Records::create((object) $arr);

        $this->assertInstanceOf(Record::class, $records[0]);
        $this->assertCount(3, $records);
    }

    public function testOffsetSetException(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $records = Records::create((object) ['items' => []]);
        $records[0] = Record::create($this->recordObject());
    }

    public function testOffsetUnsetException(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $records = Records::create((object) ['items' => []]);
        unset($records[0]);
    }

    private function recordObject(): \stdClass
    {
        return (object) [
            'zone_id' => 'zoneId',
            'name' => 'name',
            'type' => 'MX',
            'values' => ['value1', 'value2'],
            'ttl' => '3600',
            'enables' => true,
            'readonly' => true,
        ];
    }
}
