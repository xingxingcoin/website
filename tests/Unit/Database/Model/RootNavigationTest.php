<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database\Model;

use App\Database\Model\RootNavigation;
use App\Exception\EmptyStringException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RootNavigation::class)]
final class RootNavigationTest extends TestCase
{
    public function testRootNavigationTestIsValid(): void
    {
        $rootNavigation = new RootNavigation('test');
        self::assertSame('test', $rootNavigation->value);
    }

    public function testRootNavigationTestWithEmptyString(): void
    {
        try {
            new RootNavigation('');
            $this->fail('EmptyStringException was expected to be thrown.');
        } catch (EmptyStringException $exception) {
            self::assertSame(
                'Validation failed for value "rootNavigation" with error: "Value for "rootNavigation" should not be empty."',
                $exception->getMessage(),
            );
        }
    }
}
