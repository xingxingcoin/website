<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Tests\Gallery\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Xingxingcoin\Core\Gallery\Model\RootNavigation;
use Xingxingcoin\JsonValidator\Validation\Exception\EmptyStringException;

#[CoversClass(RootNavigation::class)]
final class RootNavigationTest extends TestCase
{
    public function testRootNavigationTest_is_valid(): void
    {
        $rootNavigation = new RootNavigation('test');
        self::assertSame('test', $rootNavigation->value);
    }

    public function testRootNavigationTest_with_empty_string(): void
    {
        try {
            new RootNavigation('');
            $this->fail('EmptyStringException was expected to be thrown.');
        } catch (EmptyStringException $exception) {
            self::assertSame('Validation failed for value "rootNavigation" with error: "Value for "rootNavigation" should not be empty."', $exception->getMessage());
        }
    }
}
