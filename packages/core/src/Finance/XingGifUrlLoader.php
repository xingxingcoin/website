<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Finance;

use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use XingXingCoin\Core\Database\Exception\PageDocumentNotLoadedException;
use XingXingCoin\Core\Finance\Exception\XingGifNotFoundException;
use XingXingCoin\Core\Model\Location;
use XingXingCoin\Core\Exception\EmptyStringException;

interface XingGifUrlLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     * @throws XingGifNotFoundException
     * @throws EmptyStringException
     */
    public function load(FinanceDataCollection $financeDataCollection, Location $location): FinanceDataCollection;
}
