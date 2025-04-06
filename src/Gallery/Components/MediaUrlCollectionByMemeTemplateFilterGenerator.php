<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\MediaUrlCollection;

final readonly class MediaUrlCollectionByMemeTemplateFilterGenerator implements MediaUrlCollectionByFilterGenerator
{
    public const string FILE_NAME_TEMPLATE = 'template';

    #[\Override]
    public function generate(MediaCollection $mediaCollection): MediaUrlCollection
    {
        $mediaUrlData = [];
        foreach ($mediaCollection as $mediaData) {
            if (str_contains(
                $mediaData[MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_NAME_KEY],
                self::FILE_NAME_TEMPLATE
            )) {
                $mediaUrlData[] = [
                    MemeGeneratorMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => $mediaData[MemeGeneratorMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY],
                    MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_URL_KEY => $mediaData[MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_URL_KEY]
                ];
            }
        }

        return new MediaUrlCollection($mediaUrlData);
    }
}
