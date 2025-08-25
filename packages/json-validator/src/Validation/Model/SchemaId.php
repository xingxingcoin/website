<?php

declare(strict_types=1);

namespace Xingxingcoin\JsonValidator\Validation\Model;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final readonly class SchemaId
{
    public function __construct(
        public string $value
    ) {}
}
