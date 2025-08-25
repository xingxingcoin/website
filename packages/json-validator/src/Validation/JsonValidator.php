<?php

declare(strict_types=1);

namespace Xingxingcoin\JsonValidator\Validation;

use Xingxingcoin\JsonValidator\Validation\Exception\InvalidHttpJsonResponseSchema;
use Xingxingcoin\JsonValidator\Validation\Model\JsonString;
use Xingxingcoin\JsonValidator\Validation\Model\SchemaId;
use Xingxingcoin\JsonValidator\Validation\Model\SchemaPath;
use Opis\JsonSchema\ValidationResult;

interface JsonValidator
{
    /**
     * @throws InvalidHttpJsonResponseSchema
     */
    public function validate(JsonString $jsonString, SchemaPath $schemaPath, SchemaId $schemaId): ValidationResult;
}
