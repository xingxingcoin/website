<?php

declare(strict_types=1);

namespace App\Tests\Unit\Http;

use App\Exception\InvalidHttpJsonResponseSchema;
use App\Http\ApiHttpClient;
use App\Json\Model\JsonString;
use App\Tests\Unit\Http\Mocks\JsonValidatorMock;
use App\Tests\Unit\Http\Mocks\SchemaMock;
use App\Tests\Unit\Mocks\HttpClientMock;
use App\Tests\Unit\Mocks\LoggerMock;
use App\Tests\Unit\Mocks\ResponseMock;
use Opis\JsonSchema\Errors\ValidationError;
use Opis\JsonSchema\Info\DataInfo;
use Opis\JsonSchema\ValidationResult;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApiHttpClient::class)]
#[CoversClass(JsonString::class)]
final class ApiHttpClientTest extends TestCase
{
    private JsonValidatorMock $jsonValidatorMock;
    private HttpClientMock $httpClientMock;
    private LoggerMock $loggerMock;
    private ApiHttpClient $apiHttpClient;

    protected function setUp(): void
    {
        $this->jsonValidatorMock = new JsonValidatorMock();
        $this->httpClientMock = new HttpClientMock();
        $this->loggerMock = new LoggerMock();
        $this->apiHttpClient = new ApiHttpClient($this->jsonValidatorMock, $this->httpClientMock, $this->loggerMock);
    }

    public function testRequest_is_valid(): void
    {
        $method = 'GET';
        $url = 'test-valid.com';
        $options = ['test'];

        $expectedResponseMock = new ResponseMock();
        $expectedResponseMock->outputStatusCode = 200;
        $expectedResponseMock->outputContent = 'test';
        $this->httpClientMock->outputResponse = $expectedResponseMock;
        $expectedValidatorResult = new ValidationResult(null);
        $this->jsonValidatorMock->outputValidationResult = $expectedValidatorResult;

        $response = $this->apiHttpClient->request($method, $url, $options);

        self::assertSame('test', $response->getContent());
        self::assertSame(200, $response->getStatusCode());
        self::assertSame($url, $this->httpClientMock->inputUrl);
        self::assertSame($method, $this->httpClientMock->inputMethod);
        self::assertSame($options, $this->httpClientMock->inputOptions);
        self::assertSame('test', $this->jsonValidatorMock->inputJsonString->value);
        self::assertSame('test-valid.com.json', $this->jsonValidatorMock->inputSchemaId->value);
        self::assertSame(
            '/var/www/html/src/Http/Schema/test-valid.com.json',
            $this->jsonValidatorMock->inputSchemaPath->value
        );
        self::assertEquals([], $this->loggerMock->logs);
    }

    public function testRequest_without_existing_json_schema_file(): void
    {
        $method = 'GET';
        $url = 'test-valid2.com';
        $options = ['test'];

        $expectedResponseMock = new ResponseMock();
        $expectedResponseMock->outputStatusCode = 200;
        $expectedResponseMock->outputContent = 'test';
        $this->httpClientMock->outputResponse = $expectedResponseMock;
        $expectedValidatorResult = new ValidationResult(null);
        $this->jsonValidatorMock->outputValidationResult = $expectedValidatorResult;

        try {
            $this->apiHttpClient->request($method, $url, $options);
            $this->fail('InvalidHttpJsonResponseSchema was expected to be thrown.');
        } catch (InvalidHttpJsonResponseSchema $exception) {
            self::assertSame(
                'Validation failed for value "test-valid2.com" with error: "Json response for url "test-valid2.com" and method "GET" is not existing."',
                $exception->getMessage()
            );
        }
        self::assertEquals([
            'error' => [
                [
                    'message' => 'JSON schema for for url and method not found.',
                    'context' => [
                        'url' => 'test-valid2.com',
                        'method' => 'GET'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testRequest_with_errors_in_validation_result(): void
    {
        $method = 'GET';
        $url = 'test-valid.com';
        $options = ['test'];

        $expectedResponseMock = new ResponseMock();
        $expectedResponseMock->outputStatusCode = 200;
        $expectedResponseMock->outputContent = 'test';
        $this->httpClientMock->outputResponse = $expectedResponseMock;
        $schemaMock = new SchemaMock();
        $dataInfo = new DataInfo('testValue', 'testType', 'testRoot');
        $message = 'testMessage';
        $validationError = new ValidationError(
            'test',
            $schemaMock,
            $dataInfo,
            $message
        );
        $expectedValidatorResult = new ValidationResult($validationError);
        $this->jsonValidatorMock->outputValidationResult = $expectedValidatorResult;

        try {
            $this->apiHttpClient->request($method, $url, $options);
            $this->fail('InvalidHttpJsonResponseSchema was expected to be thrown.');
        } catch (InvalidHttpJsonResponseSchema $exception) {
            self::assertSame(
                'Validation failed for value "test-valid.com" with error: "Json schema for url "test-valid.com" and method "GET" is invalid."',
                $exception->getMessage()
            );
        }
        self::assertEquals([
            'error' => [
                [
                    'message' => 'Could not validate input json.',
                    'context' => [
                        'errorMessage' => $message
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }
}
