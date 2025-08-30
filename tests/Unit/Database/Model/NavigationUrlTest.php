<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database\Model;

use App\Database\Model\NavigationUrl;
use App\Exception\EmptyStringException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NavigationUrl::class)]
final class NavigationUrlTest extends TestCase
{
    public function testLMediaNavigationUrlIsValid(): void
    {
        $expectedMediaNavigationUrlAsString = 'testLocation';
        $mediaNavigationUrl = new NavigationUrl($expectedMediaNavigationUrlAsString);
        self::assertSame($expectedMediaNavigationUrlAsString, $mediaNavigationUrl->value);
    }

    public function testLocationWithEmptyString(): void
    {
        $expectedMediaNavigationUrlAsString = '';
        try {
            new NavigationUrl($expectedMediaNavigationUrlAsString);
        } catch (EmptyStringException $exception) {
            self::assertSame(
                'Validation failed for value "mediaNavigationUrl" with error: "Value for "mediaNavigationUrl" should not be empty."',
                $exception->getMessage(),
            );
        }
    }
}
