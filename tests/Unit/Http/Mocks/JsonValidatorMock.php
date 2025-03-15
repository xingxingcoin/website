<?php

declare(strict_types=1);

namespace App\Tests\Unit\Http\Mocks;

use App\Http\JsonValidator;
use App\Json\Model\JsonString;
use App\Json\Model\SchemaId;
use App\Json\Model\SchemaPath;
use Opis\JsonSchema\ValidationResult;

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
