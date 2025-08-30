<?php

declare(strict_types=1);

namespace App\Database\Exception;

use App\Exception\ValidationException;

/**
 * @codeCoverageIgnore
 *
 * @infection-ignore-all
 */
final class MediaNotFoundException extends ValidationException
{
    public const string MEDIA_NOT_LOADED_EXCEPTION_MESSAGE = 'Media with id "%s" could not be loaded.';

    public static function mediaIsInvalid(string $mediaId): self
    {
        return new self(
            ValidationException::buildMessage(
                $mediaId,
                \sprintf(
                    self::MEDIA_NOT_LOADED_EXCEPTION_MESSAGE,
                    $mediaId,
                ),
            ),
        );
    }
}
