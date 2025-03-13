<?php
declare(strict_types=1);

namespace App\Tests\Unit\Finance\Mocks;

use App\Finance\Exception\XingFinanceDataNotLoadedException;
use App\Finance\Model\FinanceDataCollection;
use App\Finance\XingFinanceDataByDexScreenerApiLoader;

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
