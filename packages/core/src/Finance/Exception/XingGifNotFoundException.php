<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Finance\Exception;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final class XingGifNotFoundException extends \Exception
{
    public const string EXCEPTION_MESSAGE = 'Xing gif is not found with error: "%s".';

    public static function gifNotFound(string $error): XingGifNotFoundException
    {
        return new self(sprintf(self::EXCEPTION_MESSAGE, $error));
    }
}
