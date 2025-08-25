<?php

declare(strict_types=1);

namespace Xingxingcoin\ApiAdapter\Finance;

use Xingxingcoin\ApiAdapter\Finance\Exception\XingFinanceDataNotLoadedException;
use Xingxingcoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use Xingxingcoin\Core\Finance\XingFinanceDataByDexScreenerApiLoader as XingFinanceDataByDexScreenerApiLoaderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class XingFinanceDataByDexScreenerApiLoader implements XingFinanceDataByDexScreenerApiLoaderInterface
{
    public const string METHOD = 'GET';
    public const string URL = 'https://api.dexscreener.com/token-pairs/v1/solana/5JcdnWEwuHh1v3SAARq8zH9tEwDQGpaHzBrZ81m4pump';

    public function __construct(
        private HttpClientInterface $client,
        private LoggerInterface $logger
    ) {}

    /**
     * @throws XingFinanceDataNotLoadedException
     */
    #[\Override]
    public function load(): FinanceDataCollection
    {
        try {
            $this->logger->info('Start loading xing finance data.');
            $response = $this->client->request(self::METHOD, self::URL);
            $this->logger->info('Xing finance data is loaded successfully.');

            return new FinanceDataCollection($response->toArray()[0]);
        } catch (\Throwable $exception) {
            throw new XingFinanceDataNotLoadedException($exception->getMessage());
        }
    }
}
