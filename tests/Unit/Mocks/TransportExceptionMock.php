<?php

declare(strict_types=1);

namespace App\Tests\Unit\Mocks;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class TransportExceptionMock extends \Exception implements TransportExceptionInterface
{
    public string $outputString;

    public function __toString(): string
    {
        return $this->outputString;
    }
}
