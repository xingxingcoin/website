<?php

declare(strict_types=1);

namespace Xingxingcoin\ApiAdapter\Finance\Model;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @template-implements IteratorAggregate<int, mixed>
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final readonly class FinanceDataCollection implements IteratorAggregate
{
    public function __construct(public array $data)
    {
    }

    #[\Override]
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }
}
