<?php

declare(strict_types=1);

namespace App\Gallery;

use App\Database\DocumentByPathLoader;
use App\Database\Exception\MediaNotFoundException;
use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\DocumentPath;
use App\Database\Model\Location;
use App\Database\Model\RootNavigation;
use App\Database\Model\SubNavigation;
use Sulu\Component\DocumentManager\PathBuilder;
use XingXingCoin\Core\Exception\EmptyStringException;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\MediaUrlCollectionByDocumentLoader;
use XingXingCoin\Core\Gallery\MediaUrlCollectionRandomizer;
use XingXingCoin\Core\Gallery\MemeGeneratorImagesLoadHandler as MemeGeneratorImagesLoadHandlerInterface;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

final readonly class MemeGeneratorImagesLoadHandler implements MemeGeneratorImagesLoadHandlerInterface
{
    public const string PATH = 'meme-generator';
    public const int NUMBER_OF_PROVIDED_IMAGES = 30;
    public const int NEXT_IMAGE_COUNTER = 1;
    public const string ROOT_NAVIGATION = 'meme_generator';
    public const string SUB_NAVIGATION = 'new_meme';

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
