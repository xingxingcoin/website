<?php

declare(strict_types=1);

namespace Xingxingcoin\JsonValidator\Validation\Exception;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final class InvalidHttpJsonResponseSchema extends ValidationException
{
    public static function schemaNotFound(string $url, string $method): InvalidHttpJsonResponseSchema
    {
        return new self(
            ValidationException::buildMessage(
                $url,
                sprintf('Json response for url "%s" and method "%s" is not existing.', $url, $method)
            )
        );
    }

    public static function jsonSchemaValidatorIsInvalid(string $identifier): InvalidHttpJsonResponseSchema
    {
        return new self(
            ValidationException::buildMessage(
                $identifier,
                sprintf('Json schema validator component "%s" is not created successfully.', $identifier)
            )
        );
    }

    public static function jsonSchemaIsInvalid(string $url, string $method): InvalidHttpJsonResponseSchema
    {
        return new self(
            ValidationException::buildMessage(
                $url,
                sprintf('Json schema for url "%s" and method "%s" is invalid.', $url, $method)
            )
        );
    }
}
