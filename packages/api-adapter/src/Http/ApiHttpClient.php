<?php

declare(strict_types=1);

namespace XingXingCoin\ApiAdapter\Http;

use Opis\JsonSchema\Errors\ValidationError;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;
use XingXingCoin\JsonValidator\Validation\Exception\EmptyStringException;
use XingXingCoin\JsonValidator\Validation\Exception\InvalidHttpJsonResponseSchema;
use XingXingCoin\JsonValidator\Validation\JsonValidator;
use XingXingCoin\JsonValidator\Validation\Model\JsonString;
use XingXingCoin\JsonValidator\Validation\Model\SchemaId;
use XingXingCoin\JsonValidator\Validation\Model\SchemaPath;

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
            $this->logger->notice('JSON schema for for url and method not found.', [
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
            $this->logger->notice('Could not validate input json.', [
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
