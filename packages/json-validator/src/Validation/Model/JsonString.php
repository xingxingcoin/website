<?php

declare(strict_types=1);

namespace Xingxingcoin\JsonValidator\Validation\Model;

use Xingxingcoin\JsonValidator\Validation\Exception\EmptyStringException;

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
