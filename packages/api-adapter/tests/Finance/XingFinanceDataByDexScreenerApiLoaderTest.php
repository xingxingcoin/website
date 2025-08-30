<?php

declare(strict_types=1);

namespace XingXingCoin\ApiAdapter\Tests\Finance;

use App\Tests\Unit\Mocks\LoggerMock;
use App\Tests\Unit\Mocks\ResponseMock;
use App\Tests\Unit\Mocks\TransportExceptionMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use XingXingCoin\ApiAdapter\Finance\Exception\XingFinanceDataNotLoadedException;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use XingXingCoin\ApiAdapter\Finance\XingFinanceDataByDexScreenerApiLoader;
use XingXingCoin\ApiAdapter\Tests\Mocks\HttpClientMock;

#[CoversClass(XingFinanceDataByDexScreenerApiLoader::class)]
final class XingFinanceDataByDexScreenerApiLoaderTest extends TestCase
{
    private HttpClientMock $httpClientMock;
    private LoggerMock $loggerMock;
    private XingFinanceDataByDexScreenerApiLoader $xingFinanceDataByDexScreenerApiLoader;

    protected function setUp(): void
    {
        $this->httpClientMock = new HttpClientMock();
        $this->loggerMock = new LoggerMock();
        $this->xingFinanceDataByDexScreenerApiLoader = new XingFinanceDataByDexScreenerApiLoader(
            $this->httpClientMock,
            $this->loggerMock,
        );
    }

    public function testLoadIsValid(): void
    {
        $expectedBodyAsArray = [['testBody']];
        $expectedBody = 'testBody';
        $responseMock = new ResponseMock();
        $responseMock->outputStatusCode = 200;
        $responseMock->outputContent = 'testBody';
        $responseMock->outputResponseAsArray = $expectedBodyAsArray;
        $this->httpClientMock->outputResponse = $responseMock;
        $xingFinanceData = $this->xingFinanceDataByDexScreenerApiLoader->load();

        self::assertEquals(new FinanceDataCollection([$expectedBody]), $xingFinanceData);

        self::assertSame(XingFinanceDataByDexScreenerApiLoader::METHOD, $this->httpClientMock->inputMethod);
        self::assertSame(XingFinanceDataByDexScreenerApiLoader::URL, $this->httpClientMock->inputUrl);
        self::assertEquals([], $this->httpClientMock->inputOptions);

        self::assertEquals([
            'info' => [
                [
                    'message' => 'Start loading xing finance data.',
                    'context' => [],
                ],
                [
                    'message' => 'Xing finance data is loaded successfully.',
                    'context' => [],
                ],
            ],
        ], $this->loggerMock->logs);
    }

    public function testLoadWithHttpClientException(): void
    {
        $this->httpClientMock->throwTransportException = new TransportExceptionMock('test');
        try {
            $this->xingFinanceDataByDexScreenerApiLoader->load();
            $this->fail('XingFinanceDataNotLoadedException was expected to be thrown.');
        } catch (XingFinanceDataNotLoadedException $exception) {
            self::assertSame('test', $exception->getMessage());
        }

        self::assertSame(XingFinanceDataByDexScreenerApiLoader::METHOD, $this->httpClientMock->inputMethod);
        self::assertSame(XingFinanceDataByDexScreenerApiLoader::URL, $this->httpClientMock->inputUrl);
        self::assertEquals([], $this->httpClientMock->inputOptions);

        self::assertEquals([
            'info' => [
                [
                    'message' => 'Start loading xing finance data.',
                    'context' => [],
                ],
            ],
            'notice' => [
                [
                    'message' => 'Failed loading xing finance data.',
                    'context' => [
                        'exceptionMessage' => 'test',
                    ],
                ],
            ],
        ], $this->loggerMock->logs);
    }

    public function testLoadWithInvalidResponseCode(): void
    {
        $expectedBodyAsArray = [['testBody']];
        $responseMock = new ResponseMock();
        $responseMock->outputStatusCode = 500;
        $responseMock->outputContent = 'testBody';
        $responseMock->outputResponseAsArray = $expectedBodyAsArray;
        $this->httpClientMock->outputResponse = $responseMock;

        try {
            $this->xingFinanceDataByDexScreenerApiLoader->load();
            $this->fail('XingFinanceDataNotLoadedException was expected to be thrown.');
        } catch (XingFinanceDataNotLoadedException $exception) {
            self::assertSame('Response code is not 200.', $exception->getMessage());
        }

        self::assertSame(XingFinanceDataByDexScreenerApiLoader::METHOD, $this->httpClientMock->inputMethod);
        self::assertSame(XingFinanceDataByDexScreenerApiLoader::URL, $this->httpClientMock->inputUrl);
        self::assertEquals([], $this->httpClientMock->inputOptions);

        self::assertEquals([
            'info' => [
                [
                    'message' => 'Start loading xing finance data.',
                    'context' => [],
                ],
            ],
            'notice' => [
                [
                    'message' => 'Loading xing finance data has no response code 200.',
                    'context' => [
                        'statusCode' => 500,
                    ],
                ],
                [
                    'message' => 'Failed loading xing finance data.',
                    'context' => [
                        'exceptionMessage' => 'Response code is not 200.',
                    ],
                ],
            ],
        ], $this->loggerMock->logs);
    }
}
