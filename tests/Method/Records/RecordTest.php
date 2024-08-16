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
        $this->assertSame(RecordType::A, RecordType::from('A'));
        $this->assertSame(RecordType::CNAME, RecordType::from('CNAME'));
        $this->assertSame(RecordType::MX, RecordType::from('MX'));
        $this->assertSame(RecordType::TXT, RecordType::from('TXT'));
        $this->assertSame(RecordType::SRV, RecordType::from('SRV'));
        $this->assertSame(RecordType::NS, RecordType::from('NS'));
        $this->assertSame(RecordType::SOA, RecordType::from('SOA'));
        $this->assertSame(RecordType::AAAA, RecordType::from('AAAA'));
    }

    public function testTtlIsInteger(): void
    {
        $record = Record::create($this->recordObject());

        $this->assertSame(3600, $record->ttl);
    }

    public function testRecordsCreate(): void
    {
        $records = Records::create((object) [
            'items' => [
                $this->recordObject(),
                $this->recordObject(),
                $this->recordObject(),
            ],
        ]);

        $this->assertCount(3, $records);
        $this->assertContainsOnlyInstancesOf(Record::class, $records);
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
