<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Tests\Gallery\Model;

use App\Exception\EmptyStringException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Xingxingcoin\Core\Gallery\Model\SubNavigation;

#[CoversClass(SubNavigation::class)]
final class SubNavigationTest extends TestCase
{
    public function testSubNavigation_is_valid(): void
    {
        $subNavigation = new SubNavigation('test');
        self::assertSame('test', $subNavigation->value);
    }

    public function testSubNavigation_with_empty_string(): void
    {
        try {
            new SubNavigation('');
            $this->fail('EmptyStringException was expected to be thrown.');
        } catch (EmptyStringException $exception) {
            self::assertSame('Validation failed for value "subNavigation" with error: "Value for "subNavigation" should not be empty."', $exception->getMessage());
        }
    }
}
