<?php

declare(strict_types=1);

namespace App\Gallery;

use Sulu\Component\DocumentManager\PathBuilder;
use Xingxingcoin\Core\Database\DocumentByPathLoader;
use Xingxingcoin\Core\Gallery\MediaCollectionByDocumentLoader;
use Xingxingcoin\Core\Gallery\MediaUrlCollectionByFilterGenerateHandler;
use Xingxingcoin\Core\Gallery\MediaUrlCollectionRandomizer;
use Xingxingcoin\Core\Gallery\MemeGeneratorImagesFilterLoadHandler as MemeGeneratorImagesFilterLoadHandlerInterface;
use Xingxingcoin\Core\Gallery\Model\ImageCounter;
use Xingxingcoin\Core\Gallery\Model\ImageFilter;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;
use Xingxingcoin\Core\Gallery\Model\RootNavigation;
use Xingxingcoin\Core\Gallery\Model\SubNavigation;
use Xingxingcoin\Core\Model\Location;

final readonly class MemeGeneratorImagesFilterLoadHandler implements MemeGeneratorImagesFilterLoadHandlerInterface
{
    public const string PATH = 'meme-generator';
    public const int NUMBER_OF_PROVIDED_IMAGES = 30;
    public const int NEXT_IMAGE_COUNTER = 1;
    public const string ROOT_NAVIGATION = 'meme_generator';
    public const string SUB_NAVIGATION = 'new_meme';

    public function __construct(
        private PathBuilder $pathBuilder,
        private DocumentByPathLoader $documentByPathLoader,
        private MediaCollectionByDocumentLoader $mediaCollectionByDocumentLoader,
        private MediaUrlCollectionByFilterGenerateHandler $mediaUrlCollectionByFilterGenerateHandler,
        private MediaUrlCollectionRandomizer $mediaUrlCollectionRandomizer
    ) {
    }

    /**
     * @throws \Xingxingcoin\Core\Gallery\Exception\MediaDataNotLoadedException
     * @throws \Xingxingcoin\Core\Database\Exception\PageDocumentNotLoadedException
     */
    #[\Override]
    public function handle(Location $location, ImageCounter $imageCounter, ImageFilter $imageFilter): MediaUrlCollection
    {
        $path = $this->pathBuilder->build(['%base%', 'website', '%content%', self::PATH]);
        $document = $this->documentByPathLoader->load($path);
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
