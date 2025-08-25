<?php

declare(strict_types=1);

namespace XingXingCoin\ApiAdapter\Tests\Http\Mocks;

use Opis\JsonSchema\ValidationResult;
use XingXingCoin\JsonValidator\Validation\JsonValidator;
use XingXingCoin\JsonValidator\Validation\Model\JsonString;
use XingXingCoin\JsonValidator\Validation\Model\SchemaId;
use XingXingCoin\JsonValidator\Validation\Model\SchemaPath;

final class JsonValidatorMock implements JsonValidator
{
    public JsonString $inputJsonString;
    public SchemaPath $inputSchemaPath;
    public SchemaId $inputSchemaId;
    public ValidationResult $outputValidationResult;

    public function validate(JsonString $jsonString, SchemaPath $schemaPath, SchemaId $schemaId): ValidationResult
    {
        $this->inputJsonString = $jsonString;
        $this->inputSchemaPath = $schemaPath;
        $this->inputSchemaId = $schemaId;

        return $this->outputValidationResult;
    }
}
