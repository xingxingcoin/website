<?php
declare(strict_types=1);

namespace App\Tests\Unit\Finance\Mocks;

use Xingxingcoin\ApiAdapter\Finance\Exception\XingFinanceDataNotLoadedException;
use Xingxingcoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use Xingxingcoin\Core\Finance\XingFinanceDataByDexScreenerApiLoader;

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
