<?php

declare(strict_types=1);

namespace App\Exception;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
class ValidationException extends \Exception
{
    private const string MESSAGE_TEMPLATE = 'Validation failed for value "%s" with error: "%s"';

    protected static function buildMessage(string $value, string $error): string
    {
        return sprintf(self::MESSAGE_TEMPLATE, $value, $error);
    }
}
