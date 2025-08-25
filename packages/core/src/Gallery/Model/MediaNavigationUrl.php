<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Gallery\Model;

use App\Exception\EmptyStringException;

final readonly class MediaNavigationUrl
{
    /**
     * @throws EmptyStringException
     */
    public function __construct(
        public string $value
    ) {
        if ($this->value === '') {
            throw EmptyStringException::stringIsEmpty('mediaNavigationUrl');
        }
    }
}
