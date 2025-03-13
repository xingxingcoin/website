<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Gallery;

use App\Gallery\Exception\EmptyStringException;
use App\Gallery\Exception\MediaUrlNotLoadedException;
use App\Gallery\Exception\PageDocumentNotLoadedException;
use App\Gallery\Model\ImageCounter;
use App\Gallery\Model\Location;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
            $imageCounterAsInt = (int)$request->get(self::REQUEST_IMAGE_COUNTER_KEY);
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
