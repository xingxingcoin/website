<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Finance;

use App\Data\Exception\PageDocumentNotLoadedException;
use App\Finance\Exception\XingGifNotFoundException;
use App\Model\Location;
use Xingxingcoin\ApiAdapter\Finance\Exception\XingFinanceDataNotLoadedException;
use Xingxingcoin\ApiAdapter\Finance\Model\FinanceDataCollection;

interface XingFinanceDataByDexScreenerApiHandler
{
    /**
     * @throws XingGifNotFoundException
     * @throws XingFinanceDataNotLoadedException
     * @throws PageDocumentNotLoadedException
     */
    public function handleAndGet(Location $location): FinanceDataCollection;
}
