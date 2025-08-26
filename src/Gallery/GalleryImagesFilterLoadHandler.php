<?php

declare(strict_types=1);

namespace App\Gallery;

use Sulu\Component\DocumentManager\PathBuilder;
use XingXingCoin\Core\Database\DocumentByPathLoader;
use XingXingCoin\Core\Database\Exception\MediaNotFoundException;
use XingXingCoin\Core\Database\Exception\PageDocumentNotLoadedException;
use XingXingCoin\Core\Database\Model\DocumentPath;
use XingXingCoin\Core\Exception\EmptyStringException;
use XingXingCoin\Core\Gallery\Exception\MediaDataNotLoadedException;
use XingXingCoin\Core\Gallery\GalleryImagesFilterLoadHandler as GalleryImagesFilterLoadHandlerInterface;
use XingXingCoin\Core\Gallery\MediaCollectionByDocumentLoader;
use XingXingCoin\Core\Gallery\MediaUrlCollectionByFilterGenerateHandler;
use XingXingCoin\Core\Gallery\MediaUrlCollectionRandomizer;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\ImageFilter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use XingXingCoin\Core\Model\Location;

final readonly class GalleryImagesFilterLoadHandler implements GalleryImagesFilterLoadHandlerInterface
{
    public const string PATH = 'xing-xing-on-camera';
    public const int NUMBER_OF_PROVIDED_IMAGES = 30;
    public const int NEXT_IMAGE_COUNTER = 1;
    public const string ROOT_NAVIGATION = 'gallery';
    public const string SUB_NAVIGATION = 'image_viewer';

    public function __construct(
        private PathBuilder $pathBuilder,
        private DocumentByPathLoader $documentByPathLoader,
        private MediaCollectionByDocumentLoader $mediaCollectionByDocumentLoader,
        private MediaUrlCollectionByFilterGenerateHandler $mediaUrlCollectionByFilterGenerateHandler,
        private MediaUrlCollectionRandomizer $mediaUrlCollectionRandomizer
    ) {
    }

    /**
     * @throws EmptyStringException
     * @throws MediaDataNotLoadedException
     * @throws PageDocumentNotLoadedException
     * @throws MediaNotFoundException
     */
    #[\Override]
    public function handle(Location $location, ImageCounter $imageCounter, ImageFilter $imageFilter): MediaUrlCollection
    {
        $path = $this->pathBuilder->build(['%base%', 'website', '%content%', self::PATH]);
        $document = $this->documentByPathLoader->load(new DocumentPath($path));
        $mediaUrlCollection = $this->mediaCollectionByDocumentLoader->load(
            $document,
            $location,
            new RootNavigation(self::ROOT_NAVIGATION),
            new SubNavigation(self::SUB_NAVIGATION)
        );
        $mediaUrlCollection = $this->mediaUrlCollectionByFilterGenerateHandler->handle(
            $mediaUrlCollection,
            $imageFilter
        );
        $mediaUrlCollectionForCounter = [];
        $nextImageIndex = ($imageCounter->value + self::NEXT_IMAGE_COUNTER) * self::NUMBER_OF_PROVIDED_IMAGES;
        for ($currentImageIndex = $imageCounter->value * self::NUMBER_OF_PROVIDED_IMAGES; $currentImageIndex < $nextImageIndex; $currentImageIndex++) {
            if (!$mediaUrlCollection->contains($currentImageIndex)) {
                break;
            }

            $mediaUrlCollectionForCounter[] = $mediaUrlCollection->data[$currentImageIndex];
        }

        return $this->mediaUrlCollectionRandomizer->randomize($mediaUrlCollectionForCounter);
    }
}
