<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Finance;

use Xingxingcoin\ApiAdapter\Finance\Exception\XingFinanceDataNotLoadedException;
use Xingxingcoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use Xingxingcoin\Core\Database\Exception\PageDocumentNotLoadedException;
use Xingxingcoin\Core\Finance\Exception\XingGifNotFoundException;
use Xingxingcoin\Core\Model\Location;

interface XingFinanceDataByDexScreenerApiHandler
{
    /**
     * @throws XingGifNotFoundException
     * @throws XingFinanceDataNotLoadedException
     * @throws PageDocumentNotLoadedException
     */
    public function handleAndGet(Location $location): FinanceDataCollection;
}
