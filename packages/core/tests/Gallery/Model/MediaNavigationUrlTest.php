<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Tests\Gallery\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use XingXingCoin\Core\Gallery\Model\MediaNavigationUrl;
use XingXingCoin\Core\Exception\EmptyStringException;

#[CoversClass(MediaNavigationUrl::class)]
final class MediaNavigationUrlTest extends TestCase
{
    public function testLMediaNavigationUrl_is_valid(): void
    {
        $expectedMediaNavigationUrlAsString = 'testLocation';
        $mediaNavigationUrl = new MediaNavigationUrl($expectedMediaNavigationUrlAsString);
        self::assertSame($expectedMediaNavigationUrlAsString, $mediaNavigationUrl->value);
    }

    public function testLocation_with_empty_string(): void
    {
        $expectedMediaNavigationUrlAsString = '';
        try {
            new MediaNavigationUrl($expectedMediaNavigationUrlAsString);
        } catch (EmptyStringException $exception) {
            self::assertSame(
                'Validation failed for value "mediaNavigationUrl" with error: "Value for "mediaNavigationUrl" should not be empty."',
                $exception->getMessage()
            );
        }
    }
}
