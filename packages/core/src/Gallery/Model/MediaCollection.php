<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Gallery\Model;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @template-implements IteratorAggregate<int, array<string, string>>
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final readonly class MediaCollection implements IteratorAggregate
{
    public function __construct(public array $data)
    {
    }

    #[\Override]
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }

    public function contains(int $index): bool
    {
        return array_key_exists($index, $this->data);
    }
}
