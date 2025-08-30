<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Finance;

use App\Controller\Api\V1\Finance\XingFinanceDataLoadController;
use App\Database\Model\Location;
use App\Tests\Unit\Controller\Api\V1\Finance\Mocks\XingFinanceDataByDexScreenerApiHandlerMock;
use App\Tests\Unit\Mocks\LoggerMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use XingXingCoin\Core\Finance\Exception\XingGifNotFoundException;

#[CoversClass(XingFinanceDataLoadController::class)]
#[UsesClass(Location::class)]
final class XingFinanceDataLoadControllerTest extends TestCase
{
    private XingFinanceDataByDexScreenerApiHandlerMock $xingFinanceDataByDexScreenerApiHandlerMock;
    private LoggerMock $loggerMock;
    private XingFinanceDataLoadController $xingFinanceDataLoadController;

    protected function setUp(): void
    {
        $this->xingFinanceDataByDexScreenerApiHandlerMock = new XingFinanceDataByDexScreenerApiHandlerMock();
        $this->loggerMock = new LoggerMock();
        $this->xingFinanceDataLoadController = new XingFinanceDataLoadController(
            $this->xingFinanceDataByDexScreenerApiHandlerMock,
            $this->loggerMock,
        );
    }

    public function testLoadXingFinanceDataIsValid(): void
    {
        $request = new Request();
        $request->setLocale('en');

        $financeData = [
            'finance' => [
                'test' => 'test',
            ],
            'url' => 'test',
        ];
        $this->xingFinanceDataByDexScreenerApiHandlerMock->outputFinanceDataCollection = new FinanceDataCollection(
            $financeData,
        );

        $response = $this->xingFinanceDataLoadController->__invoke($request);
        self::assertSame(200, $response->getStatusCode());
        self::assertSame('{"finance":{"test":"test"},"url":"test"}', $response->getContent());
        self::assertSame('en', $this->xingFinanceDataByDexScreenerApiHandlerMock->inputLocation->value);
        self::assertSame([], $this->loggerMock->logs);
    }

    public function testLoadXingFinanceDataWithXingGifNotFoundException(): void
    {
        $request = new Request();
        $request->setLocale('en');

        $financeData = [
            'finance' => [
                'test' => 'test',
            ],
            'url' => 'test',
        ];
        $this->xingFinanceDataByDexScreenerApiHandlerMock->outputFinanceDataCollection = new FinanceDataCollection($financeData);
        $this->xingFinanceDataByDexScreenerApiHandlerMock->throwXingGifNotFoundException = new XingGifNotFoundException('test');

        $response = $this->xingFinanceDataLoadController->__invoke($request);
        self::assertSame(500, $response->getStatusCode());
        self::assertSame('{"message":"Internal server error."}', $response->getContent());
        self::assertSame('en', $this->xingFinanceDataByDexScreenerApiHandlerMock->inputLocation->value);
        self::assertSame([
            'notice' => [
                [
                    'message' => 'Xing finance data is not loaded.',
                    'context' => [],
                ],
            ],
            'debug' => [
                [
                    'message' => 'Xing finance data is not loaded.',
                    'context' => [
                        'exceptionMessage' => 'test',
                    ],
                ],
            ],
        ], $this->loggerMock->logs);
    }
}
