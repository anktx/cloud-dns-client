<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Records;

final readonly class Record
{
    /**
     * @param string[] $values
     */
    public function __construct(
        public string $zoneId,
        public string $name,
        public RecordType $type,
        public array $values,
        public int $ttl,
        public bool $enables,
        public bool $readonly,
    ) {}

    public static function create(\stdClass $std): self
    {
        return new self(
            zoneId: $std->zone_id,
            name: $std->name,
            type: RecordType::from($std->type),
            values: $std->values,
            ttl: (int) $std->ttl,
            enables: $std->enables,
            readonly: $std->readonly,
        );
    }
}
