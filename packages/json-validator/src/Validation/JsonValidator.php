<?php

declare(strict_types=1);

namespace XingXingCoin\JsonValidator\Validation;

use Opis\JsonSchema\ValidationResult;
use XingXingCoin\JsonValidator\Validation\Exception\InvalidHttpJsonResponseSchema;
use XingXingCoin\JsonValidator\Validation\Model\JsonString;
use XingXingCoin\JsonValidator\Validation\Model\SchemaId;
use XingXingCoin\JsonValidator\Validation\Model\SchemaPath;

interface JsonValidator
{
    /**
     * @throws InvalidHttpJsonResponseSchema
     */
    public function validate(JsonString $jsonString, SchemaPath $schemaPath, SchemaId $schemaId): ValidationResult;
}
