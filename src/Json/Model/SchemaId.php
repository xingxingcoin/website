<?php

declare(strict_types=1);

namespace App\Json\Model;

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
