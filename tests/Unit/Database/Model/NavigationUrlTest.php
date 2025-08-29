<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use App\Database\Model\NavigationUrl;
use XingXingCoin\Core\Exception\EmptyStringException;

#[CoversClass(NavigationUrl::class)]
final class NavigationUrlTest extends TestCase
{
    public function testLMediaNavigationUrl_is_valid(): void
    {
        $expectedMediaNavigationUrlAsString = 'testLocation';
        $mediaNavigationUrl = new NavigationUrl($expectedMediaNavigationUrlAsString);
        self::assertSame($expectedMediaNavigationUrlAsString, $mediaNavigationUrl->value);
    }

    public function testLocation_with_empty_string(): void
    {
        $expectedMediaNavigationUrlAsString = '';
        try {
            new NavigationUrl($expectedMediaNavigationUrlAsString);
        } catch (EmptyStringException $exception) {
            self::assertSame(
                'Validation failed for value "mediaNavigationUrl" with error: "Value for "mediaNavigationUrl" should not be empty."',
                $exception->getMessage()
            );
        }
    }
}
