<?php declare(strict_types=1);

namespace App\Finance;

use App\Finance\Exception\XingFinanceDataNotLoadedException;
use App\Finance\Model\FinanceDataCollection;

interface XingFinanceDataByDexScreenerApiLoader
{
    /**
     * @throws XingFinanceDataNotLoadedException
     */
    public function load(): FinanceDataCollection;
}
