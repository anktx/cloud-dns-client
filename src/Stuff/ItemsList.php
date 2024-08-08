<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Stuff;

/**
 * @template T
 *
 * @implements \IteratorAggregate<int, T>
 * @implements \ArrayAccess<int, T>
 */
abstract readonly class ItemsList implements \IteratorAggregate, \ArrayAccess, \Countable
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
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \BadMethodCallException();
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new \BadMethodCallException();
    }

    public function count(): int
    {
        return \count($this->items);
    }
}
