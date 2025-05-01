<?php

declare(strict_types=1);

namespace App\Finance;

use App\Finance\Exception\XingGifNotFoundException;
use App\Finance\Model\FinanceDataCollection;
use App\Model\Location;
use App\Data\Exception\PageDocumentNotLoadedException;

interface XingGifUrlLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     * @throws XingGifNotFoundException
     */
    public function load(FinanceDataCollection $financeDataCollection, Location $location): FinanceDataCollection;
}
