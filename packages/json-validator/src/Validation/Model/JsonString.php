<?php

declare(strict_types=1);

namespace XingXingCoin\JsonValidator\Validation\Model;

use XingXingCoin\Core\Exception\EmptyStringException;

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
