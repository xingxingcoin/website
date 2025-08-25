<?php

declare(strict_types=1);

namespace XingXingCoin\JsonValidator\Validation\Model;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final readonly class SchemaPath
{
    public function __construct(
        public string $value
    ) {}
}
