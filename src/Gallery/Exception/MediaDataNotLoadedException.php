<?php

declare(strict_types=1);

namespace App\Gallery\Exception;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final class MediaDataNotLoadedException extends \Exception
{
    public const string MEDIA_NOT_FOUND_EXCEPTION_MESSAGE = 'Media with mediaId is not found with error: "%s".';
    public const string MEDIA_ID_NOT_FOUND_EXCEPTION_MESSAGE = 'Media id not found.';

    public static function mediaNotFound(string $error): MediaDataNotLoadedException
    {
        return new self(sprintf(self::MEDIA_NOT_FOUND_EXCEPTION_MESSAGE, $error));
    }

    public static function mediaIdNotFound(): MediaDataNotLoadedException
    {
        return new self(self::MEDIA_ID_NOT_FOUND_EXCEPTION_MESSAGE);
    }
}
