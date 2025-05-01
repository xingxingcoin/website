<?php
declare(strict_types=1);

namespace App\Tests\Unit\Controller\Pages\Mocks;

use App\Controller\Api\V1\Finance\XingFinanceDataByDexScreenerApiHandler;
use App\Finance\Model\FinanceDataCollection;

final class XingFinanceDataByDexScreenerApiHandlerMock implements XingFinanceDataByDexScreenerApiHandler
{
    public FinanceDataCollection $outputFinanceDataCollection;

    public function handleAndGet(): FinanceDataCollection
    {
        return $this->outputFinanceDataCollection;
    }
}
