<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Gallery;

use App\Database\Exception\MediaNotFoundException;
use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\Location;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\EmptyStringException;
use XingXingCoin\Core\Gallery\Exception\MediaDataNotLoadedException;
use XingXingCoin\Core\Gallery\MemeGeneratorImagesFilterLoadHandler;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\ImageFilter;

final readonly class MemeGeneratorImagesFilterLoadController
{
    public const string REQUEST_IMAGE_COUNTER_KEY = 'counter';
    public const string REQUEST_IMAGE_FILTER_KEY = 'filter';

    public function __construct(
        private MemeGeneratorImagesFilterLoadHandler $memeGeneratorImagesFilterLoadHandler,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $location = new Location($request->getLocale());
            $imageCounterAsInt = $request->query->getInt(self::REQUEST_IMAGE_COUNTER_KEY);
            $imageCounter = new ImageCounter($imageCounterAsInt);
            $imageFilterAsString = $request->query->getString(self::REQUEST_IMAGE_FILTER_KEY);
            $imageFilter = new ImageFilter($imageFilterAsString);
            $mediaUrlCollection = $this->memeGeneratorImagesFilterLoadHandler->handle(
                $location,
                $imageCounter,
                $imageFilter
            );

            return new JsonResponse(['urls' => $mediaUrlCollection->data], 200);
        } catch (PageDocumentNotLoadedException|EmptyStringException $exception) {
            $this->logger->notice('Page document could not be loaded.');
            $this->logger->debug('Page document could not be loaded.', [
                'exceptionMessage' => $exception->getMessage()
            ]);
            return new JsonResponse(['message' => 'Bad request.'], 400);
        } catch (MediaDataNotLoadedException|MediaNotFoundException $exception) {
            $this->logger->notice('Media urls could not be loaded.');
            $this->logger->debug('Media urls could not be loaded.', [
                'exceptionMessage' => $exception->getMessage()
            ]);
            return new JsonResponse(['message' => 'Internal server error.'], 500);
        }
    }
}
