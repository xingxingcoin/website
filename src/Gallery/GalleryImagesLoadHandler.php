<?php

declare(strict_types=1);

namespace App\Gallery;

use Sulu\Component\DocumentManager\PathBuilder;
use App\Database\DocumentByPathLoader;
use App\Database\Exception\MediaNotFoundException;
use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\DocumentPath;
use XingXingCoin\Core\Exception\EmptyStringException;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\GalleryImagesLoadHandler as GalleryImagesLoadHandlerInterface;
use XingXingCoin\Core\Gallery\MediaUrlCollectionByDocumentLoader;
use XingXingCoin\Core\Gallery\MediaUrlCollectionRandomizer;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use XingXingCoin\Core\Model\Location;

final readonly class GalleryImagesLoadHandler implements GalleryImagesLoadHandlerInterface
{
    public const string PATH = 'xing-xing-on-camera';
    public const int NUMBER_OF_PROVIDED_IMAGES = 30;
    public const int NEXT_IMAGE_COUNTER = 1;
    public const string ROOT_NAVIGATION = 'gallery';
    public const string SUB_NAVIGATION = 'image_viewer';

    public function __construct(
        private PathBuilder $pathBuilder,
        private DocumentByPathLoader $documentByPathLoader,
        private MediaUrlCollectionByDocumentLoader $mediaUrlCollectionByDocumentLoader,
        private MediaUrlCollectionRandomizer $mediaUrlCollectionRandomizer
    ) {
    }

    /**
     * @throws EmptyStringException
     * @throws MediaUrlNotLoadedException
     * @throws PageDocumentNotLoadedException
     * @throws MediaNotFoundException
     */
    #[\Override]
    public function handle(Location $location, ImageCounter $imageCounter): MediaUrlCollection
    {
        $path = $this->pathBuilder->build(['%base%', 'website', '%content%', self::PATH]);
        $document = $this->documentByPathLoader->load(new DocumentPath($path));
        $mediaUrlCollection = $this->mediaUrlCollectionByDocumentLoader->load(
            $document,
            $location,
            new RootNavigation(self::ROOT_NAVIGATION),
            new SubNavigation(self::SUB_NAVIGATION)
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
