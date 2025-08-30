<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database\Model;

use App\Database\Model\Location;
use App\Exception\EmptyStringException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Location::class)]
final class LocationTest extends TestCase
{
    public function testLocationIsValid(): void
    {
        $expectedLocationString = 'testLocation';
        $location = new Location($expectedLocationString);
        self::assertSame($expectedLocationString, $location->value);
    }

    public function testLocationWithEmptyString(): void
    {
        $expectedLocationString = '';
        try {
            new Location($expectedLocationString);
        } catch (EmptyStringException $exception) {
            self::assertSame(
                'Validation failed for value "location" with error: "Value for "location" should not be empty."',
                $exception->getMessage(),
            );
        }
    }
}
