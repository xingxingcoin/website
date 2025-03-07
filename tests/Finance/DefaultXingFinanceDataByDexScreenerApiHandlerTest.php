<?php
declare(strict_types=1);

namespace App\Tests\Finance;

use App\Finance\DefaultXingFinanceDataByDexScreenerApiHandler;
use App\Finance\Exception\XingFinanceDataNotLoadedException;
use App\Finance\Model\FinanceDataCollection;
use App\Tests\Finance\Mocks\XingFinanceDataByDexScreenerApiLoaderMock;
use App\Tests\Mocks\LoggerMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DefaultXingFinanceDataByDexScreenerApiHandler::class)]
final class DefaultXingFinanceDataByDexScreenerApiHandlerTest extends TestCase
{
    private XingFinanceDataByDexScreenerApiLoaderMock $xingFinanceDataByDexScreenerApiLoaderMock;
    private LoggerMock $loggerMock;
    private DefaultXingFinanceDataByDexScreenerApiHandler $defaultXingFinanceDataByDexScreenerApiHandler;

    protected function setUp(): void
    {
        $this->xingFinanceDataByDexScreenerApiLoaderMock = new XingFinanceDataByDexScreenerApiLoaderMock();
        $this->loggerMock = new LoggerMock();
        $this->defaultXingFinanceDataByDexScreenerApiHandler = new DefaultXingFinanceDataByDexScreenerApiHandler(
            $this->xingFinanceDataByDexScreenerApiLoaderMock,
            $this->loggerMock
        );
    }

    public function testHandleAndGet_is_valid(): void
    {
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 6.6
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet();

        $expectedFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => 6.6
        ]);
        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
    }

    public function testHandleAndGet_with_market_cap_equals_null(): void
    {
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => null,
            'priceChange' => [
                'h24' => 6.6
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet();

        $expectedFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 0.0,
            'priceChange' => 6.6
        ]);
        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
    }

    public function testHandleAndGet_with_price_change_equals_null(): void
    {
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => null
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet();

        $expectedFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => 0.0
        ]);
        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
    }

    public function testHandleAndGet_with_h24_equals_null(): void
    {
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => null
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet();

        $expectedFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => 0.0
        ]);
        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
    }

    public function testHandleAndGet_with_api_error(): void
    {
        $this->xingFinanceDataByDexScreenerApiLoaderMock->throwXingFinanceDataNotLoadedException = new XingFinanceDataNotLoadedException('test');

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet();

        $expectedFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 0.0,
            'priceChange' => 0.0
        ]);
        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'notice' => [
                [
                    'message' => 'Xing finance data is not loaded.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Xing finance data is not loaded.',
                    'context' => [
                        'exceptionMessage' => 'test'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }
}
