<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Finance;

use App\Controller\Api\V1\Finance\XingGeneralDataLoadController;
use App\Finance\Exception\XingGifNotFoundException;
use App\Finance\Model\FinanceDataCollection;
use App\Model\Location;
use App\Tests\Unit\Controller\Api\V1\Finance\Mocks\XingFinanceDataByDexScreenerApiHandlerMock;
use App\Tests\Unit\Mocks\LoggerMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

#[CoversClass(XingGeneralDataLoadController::class)]
#[CoversClass(Location::class)]
final class XingGeneralDataLoadControllerTest extends TestCase
{
    private XingFinanceDataByDexScreenerApiHandlerMock $xingFinanceDataByDexScreenerApiHandlerMock;
    private LoggerMock $loggerMock;
    private XingGeneralDataLoadController $xingGeneralDataLoadController;

    protected function setUp(): void
    {
        $this->xingFinanceDataByDexScreenerApiHandlerMock = new XingFinanceDataByDexScreenerApiHandlerMock();
        $this->loggerMock = new LoggerMock();
        $this->xingGeneralDataLoadController = new XingGeneralDataLoadController(
            $this->xingFinanceDataByDexScreenerApiHandlerMock,
            $this->loggerMock
        );
    }

    public function testLoadXingFinanceData_is_valid(): void
    {
        $request = new Request();
        $request->setLocale('en');

        $financeData = [
            'finance' => [
                'test' => 'test'
            ],
            'url' => 'test'
        ];
        $this->xingFinanceDataByDexScreenerApiHandlerMock->outputFinanceDataCollection = new FinanceDataCollection(
            $financeData
        );

        $response = $this->xingGeneralDataLoadController->__invoke($request);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('{"finance":{"test":"test"},"url":"test"}', $response->getContent());
        self::assertSame('en', $this->xingFinanceDataByDexScreenerApiHandlerMock->inputLocation->value);
        self::assertEquals([], $this->loggerMock->logs);
    }

    public function testLoadXingFinanceData_with_XingGifNotFoundException(): void
    {
        $request = new Request();
        $request->setLocale('en');

        $financeData = [
            'finance' => [
                'test' => 'test'
            ],
            'url' => 'test'
        ];
        $this->xingFinanceDataByDexScreenerApiHandlerMock->outputFinanceDataCollection = new FinanceDataCollection($financeData);
        $this->xingFinanceDataByDexScreenerApiHandlerMock->throwXingGifNotFoundException = new XingGifNotFoundException('test');

        $response = $this->xingGeneralDataLoadController->__invoke($request);
        self::assertEquals(500, $response->getStatusCode());
        self::assertEquals('{"message":"Internal server error."}', $response->getContent());
        self::assertSame('en', $this->xingFinanceDataByDexScreenerApiHandlerMock->inputLocation->value);
        self::assertEquals([
            'notice' => [
                [
                    'message' => 'Xing finance data is not loaded.',
                    'context' => [],
                ]
            ],
            'debug' => [
                [
                    'message' => 'Xing finance data is not loaded.',
                    'context' => [
                        'exceptionMessage' => 'test'
                    ],
                ]
            ]
        ], $this->loggerMock->logs);
    }
}
