<?php

declare(strict_types=1);

namespace XingXingCoin\JsonValidator\Tests\Validation\Model;

use App\Exception\EmptyStringException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use XingXingCoin\JsonValidator\Validation\Model\JsonString;

#[CoversClass(JsonString::class)]
final class JsonStringTest extends TestCase
{
    public function testJsonStringIsValid(): void
    {
        $jsonString = new JsonString('valid');
        self::assertSame('valid', $jsonString->value);
    }

    public function testJsonStringWithEmptyString(): void
    {
        try {
            new JsonString('');
            $this->fail('EmptyStringException was expected to be thrown.');
        } catch (EmptyStringException $exception) {
            self::assertSame('Validation failed for value "jsonString" with error: "Value for "jsonString" should not be empty."', $exception->getMessage());
        }
    }
}
