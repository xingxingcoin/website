<?php

declare(strict_types=1);

namespace App\Finance;

use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\Location;
use App\Exception\EmptyStringException;
use XingXingCoin\ApiAdapter\Finance\Exception\XingFinanceDataNotLoadedException;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use XingXingCoin\Core\Finance\Exception\XingGifNotFoundException;
use XingXingCoin\Core\Finance\XingFinanceDataByDexScreenerApiHandler as XingFinanceDataByDexScreenerApiHandlerInterface;
use XingXingCoin\Core\Finance\XingFinanceDataByDexScreenerApiLoader;
use XingXingCoin\Core\Finance\XingGifUrlLoader;

final readonly class XingFinanceDataByDexScreenerApiHandler implements XingFinanceDataByDexScreenerApiHandlerInterface
{
    public function __construct(
        private XingFinanceDataByDexScreenerApiLoader $xingFinanceDataLoader,
        private XingGifUrlLoader $xingHappyModeGifUrlLoader,
        private XingGifUrlLoader $xingCalmModeGifUrlLoader,
        private XingGifUrlLoader $xingNeutralModeGifUrlLoader,
        private XingGifUrlLoader $xingUpsetModeGifUrlLoader,
        private XingGifUrlLoader $xingRageModeGifUrlLoader,
    ) {
    }

    /**
     * @throws PageDocumentNotLoadedException
     * @throws XingFinanceDataNotLoadedException
     * @throws XingGifNotFoundException
     * @throws EmptyStringException
     */
    #[\Override]
    public function handleAndGet(Location $location): FinanceDataCollection
    {
        $xingFinanceData = $this->xingFinanceDataLoader->load();
        $xingPriceInformation = [];
        $xingPriceInformation['marketCap'] = $xingFinanceData->data['marketCap'] ?? 0;
        /** @var array<string, float> $priceChange */
        $priceChange = $xingFinanceData->data['priceChange'] ?? [];
        $xingPriceInformation['priceChange'] = $priceChange['h24'] ?? 0.0;
        $financeDataCollection = new FinanceDataCollection(['finance' => $xingPriceInformation]);
        if ($xingPriceInformation['priceChange'] > -10.0 && $xingPriceInformation['priceChange'] < 10.0) {
            $financeDataCollection = $this->xingNeutralModeGifUrlLoader->load($financeDataCollection, $location);
        }
        if ($xingPriceInformation['priceChange'] <= -10.0 && $xingPriceInformation['priceChange'] > -30.0) {
            $financeDataCollection = $this->xingUpsetModeGifUrlLoader->load($financeDataCollection, $location);
        }
        if ($xingPriceInformation['priceChange'] <= -30.0) {
            $financeDataCollection = $this->xingRageModeGifUrlLoader->load($financeDataCollection, $location);
        }
        if ($xingPriceInformation['priceChange'] >= 10.0 && $xingPriceInformation['priceChange'] < 30.0) {
            $financeDataCollection = $this->xingCalmModeGifUrlLoader->load($financeDataCollection, $location);
        }
        if ($xingPriceInformation['priceChange'] >= 30.0) {
            $financeDataCollection = $this->xingHappyModeGifUrlLoader->load($financeDataCollection, $location);
        }

        return $financeDataCollection;
    }
}
