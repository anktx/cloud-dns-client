<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Records;

use Anktx\Cloud\Dns\Client\Client\HttpMethod;
use Anktx\Cloud\Dns\Client\Client\Request;

final readonly class CreateRecordRequest implements Request
{
    /**
     * @param string[] $values
     */
    public function __construct(
        private string $zoneId,
        private string $name,
        private int $ttl,
        private RecordType $type,
        private array $values,
    ) {
        $this->assertValuesAreStrings();
    }

    public function method(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function url(): string
    {
        return 'clouddns/v1/zones/' . $this->zoneId . '/records';
    }

    public function data(): array
    {
        return [
            'name' => $this->name,
            'ttl' => $this->ttl,
            'type' => $this->type->name,
            'values' => $this->values,
        ];
    }

    public function resultType(): string
    {
        return Record::class;
    }

    private function assertValuesAreStrings(): void
    {
        foreach ($this->values as $value) {
            if (! \is_string($value)) {
                throw new \InvalidArgumentException('Values must be strings');
            }
        }
    }
}
