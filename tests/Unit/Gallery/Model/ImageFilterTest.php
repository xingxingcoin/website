<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Model;

use App\Exception\EmptyStringException;
use App\Gallery\Model\ImageFilter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImageFilter::class)]
final class ImageFilterTest extends TestCase
{
    public function testImageFilter_is_valid(): void
    {
        $expectedFilterString = 'testFilter';
        $imageFilter = new ImageFilter($expectedFilterString);
        self::assertSame($expectedFilterString, $imageFilter->value);
    }

    public function testImageFilter_with_empty_string(): void
    {
        $expectedFilterString = '';
        try {
            new ImageFilter($expectedFilterString);
        } catch (EmptyStringException $exception) {
            self::assertSame('Validation failed for value "filter" with error: "Value for "filter" should not be empty."', $exception->getMessage());
        }
    }
}
