<?php

declare(strict_types=1);

namespace Xingxingcoin\JsonValidator\Validation;

use Opis\JsonSchema\Resolvers\SchemaResolver;
use Opis\JsonSchema\ValidationResult;
use Opis\JsonSchema\Validator;
use Xingxingcoin\JsonValidator\Validation\Exception\InvalidHttpJsonResponseSchema;
use Xingxingcoin\JsonValidator\Validation\Model\JsonString;
use Xingxingcoin\JsonValidator\Validation\Model\SchemaId;
use Xingxingcoin\JsonValidator\Validation\Model\SchemaPath;

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
