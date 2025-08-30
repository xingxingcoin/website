<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use XingXingCoin\Core\Gallery\MediaUrlCollectionByFilterGenerateHandler;
use XingXingCoin\Core\Gallery\MediaUrlCollectionByFilterGenerator;
use XingXingCoin\Core\Gallery\Model\ImageFilter;
use XingXingCoin\Core\Gallery\Model\MediaCollection;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

final readonly class GalleryMediaUrlCollectionByFilterGenerateHandler implements MediaUrlCollectionByFilterGenerateHandler
{
    public const string IMAGE_FILTER_GIF_VALUE = 'gif';
    public const string IMAGE_FILTER_IMAGE_VALUE = 'image';

    public function __construct(
        private MediaUrlCollectionByFilterGenerator $mediaUrlCollectionByGifFilterGenerator,
        private MediaUrlCollectionByFilterGenerator $mediaUrlCollectionByAllImagesFilterGenerator,
    ) {
    }

    #[\Override]
    public function handle(MediaCollection $mediaCollection, ImageFilter $imageFilter): MediaUrlCollection
    {
        if (self::IMAGE_FILTER_GIF_VALUE === $imageFilter->value) {
            return $this->mediaUrlCollectionByGifFilterGenerator->generate($mediaCollection);
        }
        if (self::IMAGE_FILTER_IMAGE_VALUE === $imageFilter->value) {
            return $this->mediaUrlCollectionByAllImagesFilterGenerator->generate($mediaCollection);
        }

        return new MediaUrlCollection([]);
    }
}
