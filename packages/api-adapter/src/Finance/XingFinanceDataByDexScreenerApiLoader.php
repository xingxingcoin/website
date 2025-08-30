<?php

declare(strict_types=1);

namespace XingXingCoin\ApiAdapter\Finance;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use XingXingCoin\ApiAdapter\Finance\Exception\XingFinanceDataNotLoadedException;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use XingXingCoin\Core\Finance\XingFinanceDataByDexScreenerApiLoader as XingFinanceDataByDexScreenerApiLoaderInterface;

final readonly class XingFinanceDataByDexScreenerApiLoader implements XingFinanceDataByDexScreenerApiLoaderInterface
{
    public const string METHOD = 'GET';
    public const string URL = 'https://api.dexscreener.com/token-pairs/v1/solana/5JcdnWEwuHh1v3SAARq8zH9tEwDQGpaHzBrZ81m4pump';

    public function __construct(
        private HttpClientInterface $client,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @throws XingFinanceDataNotLoadedException
     */
    #[\Override]
    public function load(): FinanceDataCollection
    {
        try {
            $this->logger->info('Start loading xing finance data.');
            $response = $this->client->request(self::METHOD, self::URL);
            if (200 !== $response->getStatusCode()) {
                $this->logger->notice('Loading xing finance data has no response code 200.', [
                    'statusCode' => $response->getStatusCode(),
                ]);
                throw new XingFinanceDataNotLoadedException('Response code is not 200.');
            }
            $this->logger->info('Xing finance data is loaded successfully.');

            return new FinanceDataCollection($response->toArray()[0]);
        } catch (\Throwable $exception) {
            $this->logger->notice('Failed loading xing finance data.', [
                'exceptionMessage' => $exception->getMessage(),
            ]);
            throw new XingFinanceDataNotLoadedException($exception->getMessage());
        }
    }
}
