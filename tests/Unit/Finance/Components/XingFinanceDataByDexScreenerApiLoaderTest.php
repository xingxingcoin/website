<?php

declare(strict_types=1);

namespace App\Tests\Unit\Finance\Components;

use App\Finance\Components\XingFinanceDataByDexScreenerApiLoader;
use App\Finance\Exception\XingFinanceDataNotLoadedException;
use App\Finance\Model\FinanceDataCollection;
use App\Tests\Unit\Mocks\HttpClientMock;
use App\Tests\Unit\Mocks\LoggerMock;
use App\Tests\Unit\Mocks\ResponseMock;
use App\Tests\Unit\Mocks\TransportExceptionMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

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

    public function testLoad_is_valid(): void
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
                    'context' => []
                ],
                [
                    'message' => 'Xing finance data is loaded successfully.',
                    'context' => []
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoad_with_http_client_exception(): void
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
                    'context' => []
                ]
            ]
        ], $this->loggerMock->logs);
    }
}
