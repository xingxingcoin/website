<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Finance;

use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\Location;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use App\Exception\EmptyStringException;
use XingXingCoin\Core\Finance\Exception\XingGifNotFoundException;

interface XingGifUrlLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     * @throws XingGifNotFoundException
     * @throws EmptyStringException
     */
    public function load(FinanceDataCollection $financeDataCollection, Location $location): FinanceDataCollection;
}
