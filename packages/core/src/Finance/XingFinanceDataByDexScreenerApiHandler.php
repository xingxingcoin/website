<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Finance;

use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\Location;
use XingXingCoin\ApiAdapter\Finance\Exception\XingFinanceDataNotLoadedException;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use XingXingCoin\Core\Exception\EmptyStringException;
use XingXingCoin\Core\Finance\Exception\XingGifNotFoundException;

interface XingFinanceDataByDexScreenerApiHandler
{
    /**
     * @throws XingGifNotFoundException
     * @throws XingFinanceDataNotLoadedException
     * @throws PageDocumentNotLoadedException
     * @throws EmptyStringException
     */
    public function handleAndGet(Location $location): FinanceDataCollection;
}
