<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Gallery\Exception;

/**
 * @codeCoverageIgnore
 *
 * @infection-ignore-all
 */
final class MediaDataNotLoadedException extends \Exception
{
    public const string EXCEPTION_MESSAGE = 'Media id not found.';

    public static function mediaIdNotFound(): self
    {
        return new self(self::EXCEPTION_MESSAGE);
    }
}
