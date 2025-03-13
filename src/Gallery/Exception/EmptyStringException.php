<?php

declare(strict_types=1);

namespace App\Gallery\Exception;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final class EmptyStringException extends ValidationException
{
    public static function stringIsEmpty(string $identifier): EmptyStringException
    {
        return new self(
            parent::buildMessage(
                $identifier,
                sprintf('Value for "%s" should not be empty.', $identifier)
            )
        );
    }
}
