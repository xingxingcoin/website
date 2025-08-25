<?php
declare(strict_types=1);

namespace App\Tests\Unit\Controller\Pages\Mocks;

use App\Finance\Model\FinanceDataCollection;
use XingXingCoin\Core\Finance\XingFinanceDataByDexScreenerApiHandler;

final class XingFinanceDataByDexScreenerApiHandlerMock implements XingFinanceDataByDexScreenerApiHandler
{
    public FinanceDataCollection $outputFinanceDataCollection;

    public function handleAndGet(): FinanceDataCollection
    {
        return $this->outputFinanceDataCollection;
    }
}
