<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use Xingxingcoin\Core\Gallery\MediaUrlCollectionByFilterGenerateHandler;
use Xingxingcoin\Core\Gallery\MediaUrlCollectionByFilterGenerator;
use Xingxingcoin\Core\Gallery\Model\ImageFilter;
use Xingxingcoin\Core\Gallery\Model\MediaCollection;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

final readonly class GalleryMediaUrlCollectionByFilterGenerateHandler implements MediaUrlCollectionByFilterGenerateHandler
{
    public const string IMAGE_FILTER_GIF_VALUE = 'gif';
    public const string IMAGE_FILTER_IMAGE_VALUE = 'image';

    public function __construct(
        private MediaUrlCollectionByFilterGenerator $mediaUrlCollectionByGifFilterGenerator,
        private MediaUrlCollectionByFilterGenerator $mediaUrlCollectionByAllImagesFilterGenerator,
    ) {}

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
