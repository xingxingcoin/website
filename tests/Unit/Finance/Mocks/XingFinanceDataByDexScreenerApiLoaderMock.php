<?php

declare(strict_types=1);

namespace App\Tests\Unit\Finance\Mocks;

use XingXingCoin\ApiAdapter\Finance\Exception\XingFinanceDataNotLoadedException;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use XingXingCoin\Core\Finance\XingFinanceDataByDexScreenerApiLoader;

final class XingFinanceDataByDexScreenerApiLoaderMock implements XingFinanceDataByDexScreenerApiLoader
{
    public FinanceDataCollection $outputFinanceDataCollection;
    public ?XingFinanceDataNotLoadedException $throwXingFinanceDataNotLoadedException = null;

    /**
     * @throws XingFinanceDataNotLoadedException
     */
    public function load(): FinanceDataCollection
    {
        if ($this->throwXingFinanceDataNotLoadedException instanceof XingFinanceDataNotLoadedException) {
            throw $this->throwXingFinanceDataNotLoadedException;
        }

        return $this->outputFinanceDataCollection;
    }
}
