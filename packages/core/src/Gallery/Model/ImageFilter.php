<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Gallery\Model;

use App\Exception\EmptyStringException;

final readonly class ImageFilter
{
    /**
     * @throws EmptyStringException
     */
    public function __construct(
        public string $value
    ) {
        if ($this->value === '') {
            throw EmptyStringException::stringIsEmpty('filter');
        }
    }
}
