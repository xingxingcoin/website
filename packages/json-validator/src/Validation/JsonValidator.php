<?php

declare(strict_types=1);

namespace XingXingCoin\JsonValidator\Validation;

use XingXingCoin\JsonValidator\Validation\Exception\InvalidHttpJsonResponseSchema;
use XingXingCoin\JsonValidator\Validation\Model\JsonString;
use XingXingCoin\JsonValidator\Validation\Model\SchemaId;
use XingXingCoin\JsonValidator\Validation\Model\SchemaPath;
use Opis\JsonSchema\ValidationResult;

interface JsonValidator
{
    /**
     * @throws InvalidHttpJsonResponseSchema
     */
    public function validate(JsonString $jsonString, SchemaPath $schemaPath, SchemaId $schemaId): ValidationResult;
}
