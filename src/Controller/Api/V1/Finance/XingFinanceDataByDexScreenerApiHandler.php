<?php
declare(strict_types=1);

namespace App\Controller\Api\V1\Finance;

use App\Data\Exception\PageDocumentNotLoadedException;
use App\Finance\Exception\XingFinanceDataNotLoadedException;
use App\Finance\Exception\XingGifNotFoundException;
use App\Finance\Model\FinanceDataCollection;
use App\Model\Location;

interface XingFinanceDataByDexScreenerApiHandler
{
    /**
     * @throws XingGifNotFoundException
     * @throws XingFinanceDataNotLoadedException
     * @throws PageDocumentNotLoadedException
     */
    public function handleAndGet(Location $location): FinanceDataCollection;
}
