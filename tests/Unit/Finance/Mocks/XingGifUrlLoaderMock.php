<?php

declare(strict_types=1);

namespace App\Tests\Unit\Finance\Mocks;

use App\Database\Model\Location;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use XingXingCoin\Core\Finance\XingGifUrlLoader;

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
