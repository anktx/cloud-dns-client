<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Zones;

/**
 * @implements \IteratorAggregate<int, Zone>
 * @implements \ArrayAccess<int, Zone>
 */
final readonly class Zones implements \IteratorAggregate, \Countable, \ArrayAccess
{
    /**
     * @var Zone[]
     */
    private array $zones;

    public function __construct(
        Zone ...$zones
    ) {
        $this->zones = $zones;
    }

    public static function create(\stdClass $std): self
    {
        return
            new self(
                ...array_map(
                    fn (\stdClass $item) => Zone::create($item),
                    $std->items
                )
            );
    }

    /**
     * @return \ArrayIterator<int, Zone>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->zones);
    }

    public function count(): int
    {
        return \count($this->zones);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->zones[$offset]);
    }

    public function offsetGet(mixed $offset): Zone
    {
        return $this->zones[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \BadMethodCallException();
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new \BadMethodCallException();
    }
}
