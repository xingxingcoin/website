<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Tests\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Xingxingcoin\Core\Model\Location;
use Xingxingcoin\JsonValidator\Validation\Exception\EmptyStringException;

#[CoversClass(Location::class)]
final class LocationTest extends TestCase
{
    public function testLocation_is_valid(): void
    {
        $expectedLocationString = 'testLocation';
        $location = new Location($expectedLocationString);
        self::assertSame($expectedLocationString, $location->value);
    }

    public function testLocation_with_empty_string(): void
    {
        $expectedLocationString = '';
        try {
            new Location($expectedLocationString);
        } catch (EmptyStringException $exception) {
            self::assertSame(
                'Validation failed for value "location" with error: "Value for "location" should not be empty."',
                $exception->getMessage()
            );
        }
    }
}
