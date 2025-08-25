<?php

declare(strict_types=1);

namespace App\Tests\Unit\Finance\Mocks;

use App\Finance\XingGifUrlLoader;
use App\Model\Location;
use Xingxingcoin\ApiAdapter\Finance\Model\FinanceDataCollection;

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
