<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Zones;

final readonly class Zone
{
    public function __construct(
        public string $id,
        public string $parentId,
        public string $name,
        public bool $valid,
        public string $validationText,
        public bool $delegated,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {
    }

    public static function create(\stdClass $std): self
    {
        return new self(
            id: $std->id,
            parentId: $std->parent_id,
            name: $std->name,
            valid: $std->valid,
            validationText: $std->validation_text,
            delegated: $std->delegated,
            createdAt: \DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', $std->created_at),
            updatedAt: \DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', $std->updated_at),
        );
    }
}
