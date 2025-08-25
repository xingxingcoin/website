<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Finance;

use XingXingCoin\ApiAdapter\Finance\Exception\XingFinanceDataNotLoadedException;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use XingXingCoin\Core\Database\Exception\PageDocumentNotLoadedException;
use XingXingCoin\Core\Finance\Exception\XingGifNotFoundException;
use XingXingCoin\Core\Model\Location;

interface XingFinanceDataByDexScreenerApiHandler
{
    /**
     * @throws XingGifNotFoundException
     * @throws XingFinanceDataNotLoadedException
     * @throws PageDocumentNotLoadedException
     */
    public function handleAndGet(Location $location): FinanceDataCollection;
}
