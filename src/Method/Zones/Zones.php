<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Zones;

use Anktx\Cloud\Dns\Client\Stuff\ItemsList;

/**
 * @extends ItemsList<Zone>
 */
final readonly class Zones extends ItemsList
{
    public static function create(\stdClass $std): self
    {
        return new self(array_map(static fn(\stdClass $item) => Zone::create($item), $std->items));
    }
}
