<?php
declare(strict_types=1);

namespace App\Finance\Model;

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
    {}

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->data);
    }
}
