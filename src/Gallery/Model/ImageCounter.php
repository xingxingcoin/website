<?php
declare(strict_types=1);

namespace App\Gallery\Model;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final readonly class ImageCounter
{
    public function __construct(
      public int $value
    ) {}
}
