<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use Xingxingcoin\Core\Gallery\MediaUrlCollectionByFilterGenerateHandler;
use Xingxingcoin\Core\Gallery\MediaUrlCollectionByFilterGenerator;
use Xingxingcoin\Core\Gallery\Model\ImageFilter;
use Xingxingcoin\Core\Gallery\Model\MediaCollection;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

final readonly class MemeGeneratorMediaUrlCollectionByFilterGenerateHandler implements
    MediaUrlCollectionByFilterGenerateHandler
{
    public const string IMAGE_FILTER_TEMPLATE_VALUE = 'meme_template';
    public const string IMAGE_FILTER_IMAGE_VALUE = 'meme_image';

    public function __construct(
        private MediaUrlCollectionByFilterGenerator $mediaUrlCollectionByMemeTemplateFilterGenerator,
        private MediaUrlCollectionByFilterGenerator $mediaUrlCollectionByMemeImageFilterGenerator,
    ) {
    }

    #[\Override]
    public function handle(MediaCollection $mediaCollection, ImageFilter $imageFilter): MediaUrlCollection
    {
        if ($imageFilter->value === self::IMAGE_FILTER_TEMPLATE_VALUE) {
            return $this->mediaUrlCollectionByMemeTemplateFilterGenerator->generate($mediaCollection);
        }
        if ($imageFilter->value === self::IMAGE_FILTER_IMAGE_VALUE) {
            return $this->mediaUrlCollectionByMemeImageFilterGenerator->generate($mediaCollection);
        }

        return new MediaUrlCollection([]);
    }
}
