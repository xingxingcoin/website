<?php declare(strict_types=1);

namespace App\Finance;

use App\Controller\Api\V1\Finance\XingFinanceDataByDexScreenerApiHandler as XingFinanceDataByDexScreenerApiHandlerInterface;
use App\Finance\Exception\XingFinanceDataNotLoadedException;
use App\Finance\Model\FinanceDataCollection;
use App\Model\Location;
use App\Data\Exception\PageDocumentNotLoadedException;

final readonly class XingFinanceDataByDexScreenerApiHandler implements XingFinanceDataByDexScreenerApiHandlerInterface
{
    public function __construct(
        private XingFinanceDataByDexScreenerApiLoader $xingFinanceDataLoader,
        private XingGifUrlLoader $xingHappyModeGifUrlLoader,
        private XingGifUrlLoader $xingCalmModeGifUrlLoader,
        private XingGifUrlLoader $xingNeutralModeGifUrlLoader,
        private XingGifUrlLoader $xingUpsetModeGifUrlLoader,
        private XingGifUrlLoader $xingRageModeGifUrlLoader
    ) {}

    /**
     * @throws Exception\XingGifNotFoundException
     * @throws XingFinanceDataNotLoadedException
     * @throws PageDocumentNotLoadedException
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
