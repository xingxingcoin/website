<?php

declare(strict_types=1);

namespace App\Gallery\Model;

use App\Gallery\Exception\EmptyStringException;

final readonly class Location
{
    /**
     * @throws EmptyStringException
     */
    public function __construct(
        public string $value
    ) {
        if ($this->value === '') {
            throw EmptyStringException::stringIsEmpty($this->value);
        }
    }
}
