<?php

declare(strict_types=1);

namespace App\Gallery;

use App\Controller\Api\V1\Gallery\GalleryImagesLoadHandler as GalleryImagesLoadHandlerInterface;
use App\Data\DocumentByPathLoader;
use App\Gallery\Exception\MediaUrlNotLoadedException;
use App\Gallery\Model\ImageCounter;
use App\Gallery\Model\MediaUrlCollection;
use App\Gallery\Model\RootNavigation;
use App\Gallery\Model\SubNavigation;
use App\Model\Location;
use App\Data\Exception\PageDocumentNotLoadedException;
use Sulu\Component\DocumentManager\PathBuilder;

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
     * @throws PageDocumentNotLoadedException
     * @throws MediaUrlNotLoadedException
     */
    #[\Override]
    public function handle(Location $location, ImageCounter $imageCounter): MediaUrlCollection
    {
        $path = $this->pathBuilder->build(['%base%', 'website', '%content%', self::PATH]);
        $document = $this->documentByPathLoader->load($path);
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
