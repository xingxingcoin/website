<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Gallery\Model;

use XingXingCoin\JsonValidator\Validation\Exception\EmptyStringException;

final readonly class SubNavigation
{
    /**
     * @throws EmptyStringException
     */
    public function __construct(
        public string $value
    ) {
        if ($this->value === '') {
            throw EmptyStringException::stringIsEmpty('subNavigation');
        }
    }
}
