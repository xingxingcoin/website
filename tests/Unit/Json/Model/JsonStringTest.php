<?php

declare(strict_types=1);

namespace App\Tests\Unit\Json\Model;

use App\Exception\EmptyStringException;
use App\Json\Model\JsonString;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

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
