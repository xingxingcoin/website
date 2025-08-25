<?php

declare(strict_types=1);

namespace Xingxingcoin\ApiAdapter\Tests\Http;

use App\Tests\Unit\Mocks\LoggerMock;
use App\Tests\Unit\Mocks\ResponseMock;
use Opis\JsonSchema\Errors\ValidationError;
use Opis\JsonSchema\Info\DataInfo;
use Opis\JsonSchema\ValidationResult;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Xingxingcoin\ApiAdapter\Http\ApiHttpClient;
use Xingxingcoin\ApiAdapter\Tests\Http\Mocks\JsonValidatorMock;
use Xingxingcoin\ApiAdapter\Tests\Http\Mocks\SchemaMock;
use Xingxingcoin\ApiAdapter\Tests\Mocks\HttpClientMock;
use Xingxingcoin\JsonValidator\Validation\Exception\InvalidHttpJsonResponseSchema;
use Xingxingcoin\JsonValidator\Validation\Model\JsonString;

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
        $url = 'https://test-valid.com';
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
        self::assertSame('https://test-valid.com.json', $this->jsonValidatorMock->inputSchemaId->value);
        $expectedPath = __DIR__ . '/Schema/https__test-valid.com.json';
        $expectedPath = str_replace('tests', 'src', $expectedPath);
        self::assertSame(
            $expectedPath,
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
            'notice' => [
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
        $url = 'https://test-valid.com';
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
                'Validation failed for value "https://test-valid.com" with error: "Json schema for url "https://test-valid.com" and method "GET" is invalid."',
                $exception->getMessage()
            );
        }
        self::assertEquals([
            'notice' => [
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
