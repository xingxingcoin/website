<?php
declare(strict_types=1);

namespace App\Json;

use App\Exception\InvalidHttpJsonResponseSchema;
use App\Http\JsonValidator;
use App\Json\Model\JsonString;
use App\Json\Model\SchemaId;
use App\Json\Model\SchemaPath;
use Opis\JsonSchema\Resolvers\SchemaResolver;
use Opis\JsonSchema\ValidationResult;
use Opis\JsonSchema\Validator;

final readonly class OpisJsonValidator implements JsonValidator
{
    /**
     * @throws InvalidHttpJsonResponseSchema
     */
    #[\Override]
    public function validate(JsonString $jsonString, SchemaPath $schemaPath, SchemaId $schemaId): ValidationResult
    {
        $validator = new Validator();
        /** @var SchemaResolver $resolver */
        $resolver = $validator->resolver();
        $resolver->registerFile(
            $schemaId->value,
            $schemaPath->value
        );
        if (!json_validate($jsonString->value)) {
            throw InvalidHttpJsonResponseSchema::jsonSchemaValidatorIsInvalid('jsonString');
        }
        $jsonDecodedAsArray = json_decode($jsonString->value);

        return $validator->validate($jsonDecodedAsArray, $schemaId->value);
    }
}
