<?php declare(strict_types=1);

namespace App\Finance;

use App\Finance\Exception\XingFinanceDataNotLoadedException;
use App\Finance\Model\FinanceDataCollection;
use App\Finance\XingFinanceDataByDexScreenerApiHandler as XingFinanceDataByDexScreenerApiHandlerInterface;
use Psr\Log\LoggerInterface;

final readonly class DefaultXingFinanceDataByDexScreenerApiHandler implements XingFinanceDataByDexScreenerApiHandlerInterface
{
    public function __construct(
        private XingFinanceDataByDexScreenerApiLoader $xingFinanceDataLoader,
        private LoggerInterface $logger
    ) {}

    #[\Override]
    public function handleAndGet(): FinanceDataCollection
    {
        try {
            $xingFinanceData = $this->xingFinanceDataLoader->load();
            $xingPriceInformation = [];
            $xingPriceInformation['marketCap'] = $xingFinanceData->data['marketCap'] ?? 0;
            /** @var array<string, float> $priceChange */
            $priceChange = $xingFinanceData->data['priceChange'] ?? [];
            $xingPriceInformation['priceChange'] = $priceChange['h24'] ?? 0.0;
            return new FinanceDataCollection($xingPriceInformation);
        } catch (XingFinanceDataNotLoadedException $exception) {
            $this->logger->notice('Xing finance data is not loaded.');
            $this->logger->debug('Xing finance data is not loaded.', [
                'exceptionMessage' => $exception->getMessage()
            ]);
        }

        return new FinanceDataCollection([
            'marketCap' => 0,
            'priceChange' => 0.0
        ]);
    }
}
