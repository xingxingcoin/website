<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Finance;

use App\Model\Location;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class XingGeneralDataLoadController
{
    public function __construct(
        private XingFinanceDataByDexScreenerApiHandler $xingFinanceDataByDexScreenerApiHandler,
        private LoggerInterface $logger
    ) {}

    public function __invoke(Request $request): Response
    {
        try {
            $location = new Location($request->getLocale());
            $financeDataCollection = $this->xingFinanceDataByDexScreenerApiHandler->handleAndGet($location);

            return new JsonResponse([
                'finance' => $financeDataCollection->data['finance'],
                'url' => $financeDataCollection->data['url'],
            ], 200);
        } catch (\Throwable $exception) {
            $this->logger->notice('Xing finance data is not loaded.');
            $this->logger->debug('Xing finance data is not loaded.', [
                'exceptionMessage' => $exception->getMessage()
            ]);

            return new JsonResponse(['message' => 'Internal server error.'], 500);
        }
    }
}
