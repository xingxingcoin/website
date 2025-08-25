<?php

declare(strict_types=1);

namespace Xingxingcoin\ApiAdapter\Http;

use Opis\JsonSchema\Errors\ValidationError;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;
use Xingxingcoin\JsonValidator\Validation\Exception\EmptyStringException;
use Xingxingcoin\JsonValidator\Validation\Exception\InvalidHttpJsonResponseSchema;
use Xingxingcoin\JsonValidator\Validation\JsonValidator;
use Xingxingcoin\JsonValidator\Validation\Model\JsonString;
use Xingxingcoin\JsonValidator\Validation\Model\SchemaId;
use Xingxingcoin\JsonValidator\Validation\Model\SchemaPath;

final readonly class ApiHttpClient implements HttpClientInterface
{
    public function __construct(
        private JsonValidator $jsonValidator,
        private HttpClientInterface $httpClient,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws InvalidHttpJsonResponseSchema
     * @throws TransportExceptionInterface
     * @throws EmptyStringException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    #[\Override]
    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $response = $this->httpClient->request($method, $url, $options);

        $fileName = str_replace(':', '', str_replace('/', '_', $url));
        if (!file_exists(__DIR__ . '/Schema/' . $fileName . '.json')) {
            $this->logger->error('JSON schema for for url and method not found.', [
                'url' => $url,
                'method' => $method
            ]);
            throw InvalidHttpJsonResponseSchema::schemaNotFound($url, $method);
        }

        $validationResult = $this->jsonValidator->validate(
            new JsonString($response->getContent()),
            new SchemaPath(__DIR__ . '/Schema/' . $fileName . '.json'),
            new SchemaId($url . '.json')
        );
        if ($validationResult->hasError()) {
            /** @var ValidationError $validationError */
            $validationError = $validationResult->error();
            $this->logger->error('Could not validate input json.', [
                'errorMessage' => $validationError->message()
            ]);

            throw InvalidHttpJsonResponseSchema::jsonSchemaIsInvalid($url, $method);
        }

        return $response;
    }

    /**
     * @codeCoverageIgnore
     * @infection-ignore-all
     */
    #[\Override]
    public function stream(iterable|ResponseInterface $responses, ?float $timeout = null): ResponseStreamInterface
    {
        return $this->httpClient->stream($responses, $timeout);
    }

    /**
     * @codeCoverageIgnore
     * @infection-ignore-all
     */
    #[\Override]
    public function withOptions(array $options): static
    {
        return clone $this;
    }
}
