<?php declare(strict_types=1);

namespace App\Finance;

use App\Finance\Model\FinanceDataCollection;

interface XingFinanceDataByDexScreenerApiHandler
{
    public function handleAndGet(): FinanceDataCollection;
}
