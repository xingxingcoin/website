<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Model;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final readonly class MediaId
{
    public function __construct(
        public int $value
    ) {}
}
