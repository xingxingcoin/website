<?php
declare(strict_types=1);

namespace App\Tests\Unit\Mocks;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

final class HttpClientMock implements HttpClientInterface
{
    public string $inputMethod;
    public string $inputUrl;
    public array $inputOptions;
    public ResponseInterface $outputResponse;
    public ?TransportExceptionInterface $throwTransportException = null;


    public iterable|ResponseInterface $inputResponses;
    public ?float $inputTimeout;
    public ResponseStreamInterface $outputResponseStream;

    public HttpClientMock $outputHttpClient;

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $this->inputMethod = $method;
        $this->inputUrl = $url;
        $this->inputOptions = $options;
        if ($this->throwTransportException instanceof TransportExceptionInterface) {
            throw $this->throwTransportException;
        }

        return $this->outputResponse;
    }

    public function stream(iterable|ResponseInterface $responses, ?float $timeout = null): ResponseStreamInterface
    {
        $this->inputResponses = $responses;
        $this->inputTimeout = $timeout;

        return $this->outputResponseStream;
    }

    public function withOptions(array $options): static
    {
        $this->inputOptions = $options;

        return $this->outputHttpClient;
    }
}
