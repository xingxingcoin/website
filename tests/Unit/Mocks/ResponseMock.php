<?php

declare(strict_types=1);

namespace App\Tests\Unit\Mocks;

use Symfony\Contracts\HttpClient\ResponseInterface;

final class ResponseMock implements ResponseInterface
{
    public int $outputStatusCode;

    public bool $inputThrow;
    public array $outputHeaders;

    public string $outputContent;

    public array $outputResponseAsArray;

    public bool $isCancelCalled;

    public ?string $inputType;
    public mixed $outputInfo;

    public function getStatusCode(): int
    {
        return $this->outputStatusCode;
    }

    public function getHeaders(bool $throw = true): array
    {
        $this->inputThrow = $throw;

        return $this->outputHeaders;
    }

    public function getContent(bool $throw = true): string
    {
        $this->inputThrow = $throw;

        return $this->outputContent;
    }

    public function toArray(bool $throw = true): array
    {
        $this->inputThrow = $throw;

        return $this->outputResponseAsArray;
    }

    public function cancel(): void
    {
        $this->isCancelCalled = true;
    }

    public function getInfo(?string $type = null): mixed
    {
        $this->inputType = $type;

        return $this->outputInfo;
    }
}
