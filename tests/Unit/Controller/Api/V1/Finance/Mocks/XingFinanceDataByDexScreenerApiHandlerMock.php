<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Finance\Mocks;

use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use XingXingCoin\Core\Finance\Exception\XingGifNotFoundException;
use XingXingCoin\Core\Finance\XingFinanceDataByDexScreenerApiHandler;
use App\Model\Location;

final class XingFinanceDataByDexScreenerApiHandlerMock implements XingFinanceDataByDexScreenerApiHandler
{
    public Location $inputLocation;
    public FinanceDataCollection $outputFinanceDataCollection;
    public ?XingGifNotFoundException $throwXingGifNotFoundException = null;

    /**
     * @throws XingGifNotFoundException
     */
    public function handleAndGet(Location $location): FinanceDataCollection
    {
        $this->inputLocation = $location;
        if ($this->throwXingGifNotFoundException instanceof XingGifNotFoundException) {
            throw $this->throwXingGifNotFoundException;
        }

        return $this->outputFinanceDataCollection;
    }
}
