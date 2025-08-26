<?php

declare(strict_types=1);

namespace XingXingCoin\JsonValidator\Tests\Validation\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use XingXingCoin\Core\Exception\EmptyStringException;
use XingXingCoin\JsonValidator\Validation\Model\JsonString;

#[CoversClass(JsonString::class)]
final class JsonStringTest extends TestCase
{
    public function testJsonString_is_valid(): void
    {
        $jsonString = new JsonString('valid');
        self::assertSame('valid', $jsonString->value);
    }

    public function testJsonString_with_empty_string(): void
    {
        try {
            new JsonString('');
            $this->fail('EmptyStringException was expected to be thrown.');
        } catch (EmptyStringException $exception) {
            self::assertSame('Validation failed for value "jsonString" with error: "Value for "jsonString" should not be empty."', $exception->getMessage());
        }
    }
}
