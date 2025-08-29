<?php

declare(strict_types=1);

namespace App\Database\Model;

use XingXingCoin\Core\Exception\EmptyStringException;

final readonly class RootNavigation
{
    /**
     * @throws EmptyStringException
     */
    public function __construct(
        public string $value
    ) {
        if ($this->value === '') {
            throw EmptyStringException::stringIsEmpty('rootNavigation');
        }
    }
}
