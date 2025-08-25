<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Gallery;

use App\Exception\EmptyStringException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Xingxingcoin\Core\Database\Exception\PageDocumentNotLoadedException;
use Xingxingcoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use Xingxingcoin\Core\Gallery\GalleryImagesLoadHandler;
use Xingxingcoin\Core\Gallery\Model\ImageCounter;
use Xingxingcoin\Core\Model\Location;

final readonly class GalleryImagesInfiniteScrollingLoadController
{
    public const string REQUEST_IMAGE_COUNTER_KEY = 'counter';

    public function __construct(
        private GalleryImagesLoadHandler $galleryImagesLoadHandler,
        private LoggerInterface $logger
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $location = new Location($request->getLocale());
            $imageCounterAsInt = $request->query->getInt(self::REQUEST_IMAGE_COUNTER_KEY, 0);
            $imageCounter = new ImageCounter($imageCounterAsInt);
            $mediaUrlCollection = $this->galleryImagesLoadHandler->handle($location, $imageCounter);

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
