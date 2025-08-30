<?php

declare(strict_types=1);

namespace App\Database\Model;

use App\Exception\EmptyStringException;

final readonly class DocumentPath
{
    /**
     * @throws EmptyStringException
     */
    public function __construct(
        public string $value,
    ) {
        if ('' === $this->value) {
            throw EmptyStringException::stringIsEmpty('documentPath');
        }
    }
}
