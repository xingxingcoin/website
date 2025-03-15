<?php

declare(strict_types=1);

namespace App\Tests\Unit\Json;

use App\Exception\InvalidHttpJsonResponseSchema;
use App\Json\Model\JsonString;
use App\Json\Model\SchemaId;
use App\Json\Model\SchemaPath;
use App\Json\OpisJsonValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OpisJsonValidator::class)]
#[CoversClass(JsonString::class)]
final class OpisJsonValidatorTest extends TestCase
{
    private OpisJsonValidator $opisJsonValidator;

    protected function setUp(): void
    {
        $this->opisJsonValidator = new OpisJsonValidator();
    }

    public function testValidate_is_valid(): void
    {
        $jsonString = new JsonString('{"test":"bar"}');
        $schemaPath = new SchemaPath(__DIR__ . '/Schema/test.json');
        $schemaId = new SchemaId('https://test.com/test.json');

        $validationResult = $this->opisJsonValidator->validate($jsonString, $schemaPath, $schemaId);

        self::assertTrue($validationResult->isValid());
    }

    public function testValidate_with_invalid_json_respone(): void
    {
        $jsonString = new JsonString('{"test":"bar}');
        $schemaPath = new SchemaPath(__DIR__ . '/Schema/test.json');
        $schemaId = new SchemaId('https://test.com/test.json');

        try {
            $this->opisJsonValidator->validate($jsonString, $schemaPath, $schemaId);
            $this->fail('InvalidHttpJsonResponseSchema was expected to be thrown.');
        } catch (InvalidHttpJsonResponseSchema $exception) {
            self::assertSame('Validation failed for value "jsonString" with error: "Json schema validator component "jsonString" is not created successfully."', $exception->getMessage());
        }
    }
}
