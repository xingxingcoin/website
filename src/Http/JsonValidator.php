<?php
declare(strict_types=1);

namespace App\Http;

use App\Exception\InvalidHttpJsonResponseSchema;
use App\Json\Model\JsonString;
use App\Json\Model\SchemaId;
use App\Json\Model\SchemaPath;
use Opis\JsonSchema\ValidationResult;

interface JsonValidator
{
    /**
     * @throws InvalidHttpJsonResponseSchema
     */
    public function validate(JsonString $jsonString, SchemaPath $schemaPath, SchemaId $schemaId): ValidationResult;
}
