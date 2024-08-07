<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Records;

final class Records implements \IteratorAggregate, \Countable, \ArrayAccess
{
    private array $records;

    public function __construct(Record ...$records)
    {
        $this->records = $records;
    }

    public static function create(\stdClass $std): self
    {
        return new self(...array_map(fn (\stdClass $std) => Record::create($std), $std->items));
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->records);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->records[$offset]);
    }

    public function offsetGet(mixed $offset): Record
    {
        return $this->records[$offset];
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
        return \count($this->records);
    }
}
