<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Finance;

use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use XingXingCoin\Core\Database\Exception\PageDocumentNotLoadedException;
use XingXingCoin\Core\Finance\Exception\XingGifNotFoundException;
use XingXingCoin\Core\Model\Location;

interface XingGifUrlLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     * @throws XingGifNotFoundException
     */
    public function load(FinanceDataCollection $financeDataCollection, Location $location): FinanceDataCollection;
}
