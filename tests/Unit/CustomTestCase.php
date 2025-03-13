<?php
declare(strict_types=1);

namespace App\Tests\Unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CustomTestCase extends TestCase
{
    public function getMock(string $class): MockObject
    {
        return $this->getMockBuilder($class)->disableOriginalConstructor()->getMock();
    }
}
