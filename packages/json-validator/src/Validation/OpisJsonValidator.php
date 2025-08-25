<?php

declare(strict_types=1);

namespace XingXingCoin\JsonValidator\Validation;

use Opis\JsonSchema\Resolvers\SchemaResolver;
use Opis\JsonSchema\ValidationResult;
use Opis\JsonSchema\Validator;
use XingXingCoin\JsonValidator\Validation\Exception\InvalidHttpJsonResponseSchema;
use XingXingCoin\JsonValidator\Validation\Model\JsonString;
use XingXingCoin\JsonValidator\Validation\Model\SchemaId;
use XingXingCoin\JsonValidator\Validation\Model\SchemaPath;

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
