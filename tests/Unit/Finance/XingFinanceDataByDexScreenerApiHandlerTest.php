<?php

declare(strict_types=1);

namespace App\Tests\Unit\Finance;

use App\Database\Model\Location;
use App\Finance\XingFinanceDataByDexScreenerApiHandler;
use App\Tests\Unit\Finance\Mocks\XingFinanceDataByDexScreenerApiLoaderMock;
use App\Tests\Unit\Finance\Mocks\XingGifUrlLoaderMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;

#[CoversClass(XingFinanceDataByDexScreenerApiHandler::class)]
#[UsesClass(Location::class)]
final class XingFinanceDataByDexScreenerApiHandlerTest extends TestCase
{
    private XingFinanceDataByDexScreenerApiLoaderMock $xingFinanceDataByDexScreenerApiLoaderMock;
    private XingGifUrlLoaderMock $xingHappyModeGifUrlLoaderMock;
    private XingGifUrlLoaderMock $xingCalmModeGifUrlLoaderMock;
    private XingGifUrlLoaderMock $xingNeutralModeGifUrlLoaderMock;
    private XingGifUrlLoaderMock $xingUpsetModeGifUrlLoaderMock;
    private XingGifUrlLoaderMock $xingRageModeGifUrlLoaderMock;
    private XingFinanceDataByDexScreenerApiHandler $defaultXingFinanceDataByDexScreenerApiHandler;

    protected function setUp(): void
    {
        $this->xingFinanceDataByDexScreenerApiLoaderMock = new XingFinanceDataByDexScreenerApiLoaderMock();
        $this->xingHappyModeGifUrlLoaderMock = new XingGifUrlLoaderMock();
        $this->xingCalmModeGifUrlLoaderMock = new XingGifUrlLoaderMock();
        $this->xingNeutralModeGifUrlLoaderMock = new XingGifUrlLoaderMock();
        $this->xingUpsetModeGifUrlLoaderMock = new XingGifUrlLoaderMock();
        $this->xingRageModeGifUrlLoaderMock = new XingGifUrlLoaderMock();
        $this->defaultXingFinanceDataByDexScreenerApiHandler = new XingFinanceDataByDexScreenerApiHandler(
            $this->xingFinanceDataByDexScreenerApiLoaderMock,
            $this->xingHappyModeGifUrlLoaderMock,
            $this->xingCalmModeGifUrlLoaderMock,
            $this->xingNeutralModeGifUrlLoaderMock,
            $this->xingUpsetModeGifUrlLoaderMock,
            $this->xingRageModeGifUrlLoaderMock,
        );
    }

    public function testHandleAndGetWithHappyXingGifUrl(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 31.0,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => 31.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingHappyModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => 31.0,
            ],
        ], $this->xingHappyModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingHappyModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithHappyXingGifUrl2(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 30.0,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => 30.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingHappyModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => 30.0,
            ],
        ], $this->xingHappyModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingHappyModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithCalmXingGifUrl(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 20.0,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => 20.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingCalmModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => 20.0,
            ],
        ], $this->xingCalmModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingCalmModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithCalmXingGifUrl2(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 10.0,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => 10.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingCalmModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => 10.0,
            ],
        ], $this->xingCalmModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingCalmModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithNeutralXingGifUrl(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 5.0,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => 5.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingNeutralModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => 5.0,
            ],
        ], $this->xingNeutralModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingNeutralModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithNeutralXingGifUrl2(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 0.0,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => 0.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingNeutralModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => 0.0,
            ],
        ], $this->xingNeutralModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingNeutralModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithNeutralXingGifUrlAndNegativePriceChange(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => -5.0,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => -5.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingNeutralModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => -5.0,
            ],
        ], $this->xingNeutralModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingNeutralModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithUpsetXingGifUrl(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => -20.0,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => -20.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingUpsetModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => -20.0,
            ],
        ], $this->xingUpsetModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingUpsetModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithUpsetXingGifUrl2(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => -10.0,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => -10.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingUpsetModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => -10.0,
            ],
        ], $this->xingUpsetModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingUpsetModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithRageXingGifUrl(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => -35.0,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => -35.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingRageModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => -35.0,
            ],
        ], $this->xingRageModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingRageModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithRageXingGifUrl2(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => -30.0,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => -30.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingRageModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => -30.0,
            ],
        ], $this->xingRageModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingRageModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithInvalidMarketcap(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => null,
            'priceChange' => [
                'h24' => 31.0,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 0,
                'priceChange' => [
                    'h24' => 31.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingHappyModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 0,
                'priceChange' => 31.0,
            ],
        ], $this->xingHappyModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingHappyModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithInvalidPriceChange(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 10,
            'priceChange' => null,
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 10,
                'priceChange' => [
                    'h24' => 0.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingNeutralModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 10,
                'priceChange' => 0.0,
            ],
        ], $this->xingNeutralModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingNeutralModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGetWithInvalidPriceChangeH24(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 10,
            'priceChange' => [
                'h24' => null,
            ],
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 10,
                'priceChange' => [
                    'h24' => 0.0,
                ],
            ],
            'url' => 'https://example.com',
        ]);
        $this->xingNeutralModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertSame($expectedFinanceDataCollection, $financeDataCollection);
        self::assertSame([
            'finance' => [
                'marketCap' => 10,
                'priceChange' => 0.0,
            ],
        ], $this->xingNeutralModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingNeutralModeGifUrlLoaderMock->inputLocation->value);
    }
}
