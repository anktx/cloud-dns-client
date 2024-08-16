<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Records;

use Anktx\Cloud\Dns\Client\Stuff\ItemsList;

/**
 * @extends ItemsList<Record>
 */
final readonly class Records extends ItemsList
{
    public static function create(\stdClass $std): self
    {
        return new self(array_map(static fn(\stdClass $std) => Record::create($std), $std->items));
    }
}
