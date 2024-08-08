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
    final public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    final public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @return T
     */
    final public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    final public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \BadMethodCallException();
    }

    final public function offsetUnset(mixed $offset): void
    {
        throw new \BadMethodCallException();
    }

    final public function count(): int
    {
        return \count($this->items);
    }
}
