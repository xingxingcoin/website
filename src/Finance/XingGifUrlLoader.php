<?php

declare(strict_types=1);

namespace App\Finance;

use App\Finance\Exception\XingGifNotFoundException;
use App\Model\Location;
use App\Data\Exception\PageDocumentNotLoadedException;
use Xingxingcoin\ApiAdapter\Finance\Model\FinanceDataCollection;

interface XingGifUrlLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     * @throws XingGifNotFoundException
     */
    public function load(FinanceDataCollection $financeDataCollection, Location $location): FinanceDataCollection;
}
