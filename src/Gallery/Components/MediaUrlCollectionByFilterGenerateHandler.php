<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use App\Gallery\MediaUrlCollectionByFilterGenerateHandler as MediaUrlCollectionByFilterGenerateHandlerInterface;
use App\Gallery\Model\ImageFilter;
use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\MediaUrlCollection;

final readonly class MediaUrlCollectionByFilterGenerateHandler implements
    MediaUrlCollectionByFilterGenerateHandlerInterface
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
        if ($imageFilter->value === self::IMAGE_FILTER_GIF_VALUE) {
            return $this->mediaUrlCollectionByGifFilterGenerator->generate($mediaCollection);
        }
        if ($imageFilter->value === self::IMAGE_FILTER_IMAGE_VALUE) {
            return $this->mediaUrlCollectionByAllImagesFilterGenerator->generate($mediaCollection);
        }

        return new MediaUrlCollection([]);
    }
}
