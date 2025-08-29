<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Finance;


use XingXingCoin\ApiAdapter\Finance\Exception\XingFinanceDataNotLoadedException;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;

interface XingFinanceDataByDexScreenerApiLoader
{
    /**
     * @throws XingFinanceDataNotLoadedException
     */
    public function load(): FinanceDataCollection;
}
