<?php
declare(strict_types=1);

namespace App\Json\Model;

use App\Exception\EmptyStringException;

final readonly class JsonString
{
    /**
     * @throws EmptyStringException
     */
    public function __construct(
        public string $value
    ) {
        if ($this->value === '') {
            throw EmptyStringException::stringIsEmpty('jsonString');
        }
    }
}
