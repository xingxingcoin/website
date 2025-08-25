<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Model;

use App\Exception\EmptyStringException;

final readonly class Location
{
    /**
     * @throws EmptyStringException
     */
    public function __construct(
        public string $value
    ) {
        if ($this->value === '') {
            throw EmptyStringException::stringIsEmpty('location');
        }
    }
}
