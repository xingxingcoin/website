<?php
declare(strict_types=1);

namespace App\Tests\Controller\Pages\Mocks;

use App\Finance\Model\FinanceDataCollection;
use App\Finance\XingFinanceDataByDexScreenerApiHandler;

final class XingFinanceDataByDexScreenerApiHandlerMock implements XingFinanceDataByDexScreenerApiHandler
{
    public FinanceDataCollection $outputFinanceDataCollection;

    public function handleAndGet(): FinanceDataCollection
    {
        return $this->outputFinanceDataCollection;
    }
}
