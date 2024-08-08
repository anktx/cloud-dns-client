<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Stuff;

/**
 * @template T
 *
 * @implements \IteratorAggregate<int, T>
 */
abstract readonly class ItemsList implements \IteratorAggregate, \Countable
{
    /**
     * @param array<int, T> $items
     */
    protected function __construct(
        private array $items,
    ) {
    }

    /**
     * @return \ArrayIterator<int, T>
     */
    final public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    final public function count(): int
    {
        return \count($this->items);
    }
}
