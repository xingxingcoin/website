<?php

declare(strict_types=1);

namespace App\Tests\Unit\Finance\Mocks;

use Xingxingcoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use Xingxingcoin\Core\Finance\XingGifUrlLoader;
use Xingxingcoin\Core\Model\Location;

final class XingGifUrlLoaderMock implements XingGifUrlLoader
{
    public FinanceDataCollection $inputFinanceDataCollection;
    public Location $inputLocation;
    public FinanceDataCollection $outputFinanceDataCollection;

    public function load(FinanceDataCollection $financeDataCollection, Location $location): FinanceDataCollection
    {
        $this->inputFinanceDataCollection = $financeDataCollection;
        $this->inputLocation = $location;

        return $this->outputFinanceDataCollection;
    }
}
