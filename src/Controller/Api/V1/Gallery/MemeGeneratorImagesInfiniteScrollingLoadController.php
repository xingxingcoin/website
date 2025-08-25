<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Gallery;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use XingXingCoin\Core\Database\Exception\PageDocumentNotLoadedException;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\MemeGeneratorImagesLoadHandler;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Model\Location;
use XingXingCoin\JsonValidator\Validation\Exception\EmptyStringException;

final readonly class MemeGeneratorImagesInfiniteScrollingLoadController
{
    public const string REQUEST_IMAGE_COUNTER_KEY = 'counter';

    public function __construct(
        private MemeGeneratorImagesLoadHandler $memeGeneratorImagesLoadHandler,
        private LoggerInterface $logger
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $location = new Location($request->getLocale());
            $imageCounterAsInt = $request->query->getInt(self::REQUEST_IMAGE_COUNTER_KEY, 0);
            $imageCounter = new ImageCounter($imageCounterAsInt);
            $mediaUrlCollection = $this->memeGeneratorImagesLoadHandler->handle($location, $imageCounter);

            return new JsonResponse(['urls' => $mediaUrlCollection->data], 200);
        } catch (PageDocumentNotLoadedException|EmptyStringException $exception) {
            $this->logger->notice('Page document could not be loaded.');
            $this->logger->debug('Page document could not be loaded.', [
                'exceptionMessage' => $exception->getMessage()
            ]);
            return new JsonResponse(['message' => 'Bad request.'], 400);
        } catch (MediaUrlNotLoadedException $exception) {
            $this->logger->notice('Media urls could not be loaded.');
            $this->logger->debug('Media urls could not be loaded.', [
                'exceptionMessage' => $exception->getMessage()
            ]);
            return new JsonResponse(['message' => 'Internal server error.'], 500);
        }
    }
}
