<?php

declare(strict_types=1);

namespace App\Tests\Unit\Finance;

use App\Finance\XingFinanceDataByDexScreenerApiHandler;
use App\Tests\Unit\Finance\Mocks\XingFinanceDataByDexScreenerApiLoaderMock;
use App\Tests\Unit\Finance\Mocks\XingGifUrlLoaderMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use App\Model\Location;

#[CoversClass(XingFinanceDataByDexScreenerApiHandler::class)]
#[CoversClass(Location::class)]
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
            $this->xingRageModeGifUrlLoaderMock
        );
    }

    public function testHandleAndGet_with_happy_xing_gif_url(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 31.0
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => 31.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingHappyModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => 31.0
            ]
        ], $this->xingHappyModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingHappyModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_happy_xing_gif_url_2(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 30.0
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => 30.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingHappyModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => 30.0
            ]
        ], $this->xingHappyModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingHappyModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_calm_xing_gif_url(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 20.0
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => 20.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingCalmModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => 20.0
            ]
        ], $this->xingCalmModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingCalmModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_calm_xing_gif_url_2(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 10.0
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => 10.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingCalmModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => 10.0
            ]
        ], $this->xingCalmModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingCalmModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_neutral_xing_gif_url(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 5.0
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => 5.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingNeutralModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => 5.0
            ]
        ], $this->xingNeutralModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingNeutralModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_neutral_xing_gif_url_2(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => 0.0
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => 0.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingNeutralModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => 0.0
            ]
        ], $this->xingNeutralModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingNeutralModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_neutral_xing_gif_url_and_negative_priceChange(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => -5.0
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => -5.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingNeutralModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => -5.0
            ]
        ], $this->xingNeutralModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingNeutralModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_upset_xing_gif_url(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => -20.0
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => -20.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingUpsetModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => -20.0
            ]
        ], $this->xingUpsetModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingUpsetModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_upset_xing_gif_url_2(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => -10.0
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => -10.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingUpsetModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => -10.0
            ]
        ], $this->xingUpsetModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingUpsetModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_rage_xing_gif_url(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => -35.0
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => -35.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingRageModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => -35.0
            ]
        ], $this->xingRageModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingRageModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_rage_xing_gif_url_2(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 12,
            'priceChange' => [
                'h24' => -30.0
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => [
                    'h24' => -30.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingRageModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 12,
                'priceChange' => -30.0
            ]
        ], $this->xingRageModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingRageModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_invalid_marketcap(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => null,
            'priceChange' => [
                'h24' => 31.0
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 0,
                'priceChange' => [
                    'h24' => 31.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingHappyModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 0,
                'priceChange' => 31.0
            ]
        ], $this->xingHappyModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingHappyModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_invalid_priceChange(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 10,
            'priceChange' => null
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 10,
                'priceChange' => [
                    'h24' => 0.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingNeutralModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 10,
                'priceChange' => 0.0
            ]
        ], $this->xingNeutralModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingNeutralModeGifUrlLoaderMock->inputLocation->value);
    }

    public function testHandleAndGet_with_invalid_priceChange_h24(): void
    {
        $location = new Location('en');
        $inputFinanceDataCollection = new FinanceDataCollection([
            'marketCap' => 10,
            'priceChange' => [
                'h24' => null
            ]
        ]);
        $this->xingFinanceDataByDexScreenerApiLoaderMock->outputFinanceDataCollection = $inputFinanceDataCollection;
        $expectedFinanceDataCollection = new FinanceDataCollection([
            'finance' => [
                'marketCap' => 10,
                'priceChange' => [
                    'h24' => 0.0
                ]
            ],
            'url' => 'https://example.com'
        ]);
        $this->xingNeutralModeGifUrlLoaderMock->outputFinanceDataCollection = $expectedFinanceDataCollection;

        $financeDataCollection = $this->defaultXingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

        self::assertEquals($expectedFinanceDataCollection, $financeDataCollection);
        self::assertEquals([
            'finance' => [
                'marketCap' => 10,
                'priceChange' => 0.0
            ]
        ], $this->xingNeutralModeGifUrlLoaderMock->inputFinanceDataCollection->data);
        self::assertSame($location->value, $this->xingNeutralModeGifUrlLoaderMock->inputLocation->value);
    }
}
