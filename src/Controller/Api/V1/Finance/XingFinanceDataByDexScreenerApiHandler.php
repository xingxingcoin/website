<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Finance;

use App\Data\Exception\PageDocumentNotLoadedException;
use Xingxingcoin\ApiAdapter\Finance\Exception\XingFinanceDataNotLoadedException;
use Xingxingcoin\ApiAdapter\Finance\Model\FinanceDataCollection;
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
