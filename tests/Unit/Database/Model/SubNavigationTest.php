<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database\Model;

use App\Database\Model\SubNavigation;
use App\Exception\EmptyStringException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SubNavigation::class)]
final class SubNavigationTest extends TestCase
{
    public function testSubNavigationIsValid(): void
    {
        $subNavigation = new SubNavigation('test');
        self::assertSame('test', $subNavigation->value);
    }

    public function testSubNavigationWithEmptyString(): void
    {
        try {
            new SubNavigation('');
            $this->fail('EmptyStringException was expected to be thrown.');
        } catch (EmptyStringException $exception) {
            self::assertSame(
                'Validation failed for value "subNavigation" with error: "Value for "subNavigation" should not be empty."',
                $exception->getMessage(),
            );
        }
    }
}
