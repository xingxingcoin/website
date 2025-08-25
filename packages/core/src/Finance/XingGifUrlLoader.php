<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Finance;

use App\Data\Exception\PageDocumentNotLoadedException;
use Xingxingcoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use Xingxingcoin\Core\Finance\Exception\XingGifNotFoundException;
use Xingxingcoin\Core\Model\Location;

interface XingGifUrlLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     * @throws XingGifNotFoundException
     */
    public function load(FinanceDataCollection $financeDataCollection, Location $location): FinanceDataCollection;
}
