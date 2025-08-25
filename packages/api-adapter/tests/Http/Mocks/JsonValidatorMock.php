<?php

declare(strict_types=1);

namespace Xingxingcoin\ApiAdapter\Tests\Http\Mocks;

use Opis\JsonSchema\ValidationResult;
use Xingxingcoin\JsonValidator\Validation\JsonValidator;
use Xingxingcoin\JsonValidator\Validation\Model\JsonString;
use Xingxingcoin\JsonValidator\Validation\Model\SchemaId;
use Xingxingcoin\JsonValidator\Validation\Model\SchemaPath;

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
