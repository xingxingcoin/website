<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Database\Exception;

use App\Exception\ValidationException;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final class PageDocumentNotLoadedException extends ValidationException
{
    public const string PATH_EXCEPTION_MESSAGE = 'Path "%s" for gallery is invalid.';
    public const string DOCUMENT_NOT_LOADED_EXCEPTION_MESSAGE = 'Document with path "%s" could not be loaded with error: "%s"';

    public static function pathIsInvalid(string $path): PageDocumentNotLoadedException
    {
        return new self(sprintf(self::PATH_EXCEPTION_MESSAGE, $path));
    }

    public static function documentNotLoaded(string $path, string $error): PageDocumentNotLoadedException
    {
        return new self(sprintf(self::DOCUMENT_NOT_LOADED_EXCEPTION_MESSAGE, $path, $error));
    }
}
