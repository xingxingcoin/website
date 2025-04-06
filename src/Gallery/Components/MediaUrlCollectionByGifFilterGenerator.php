<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\MediaUrlCollection;

final readonly class MediaUrlCollectionByGifFilterGenerator implements MediaUrlCollectionByFilterGenerator
{
    public const string FILE_EXTENSION_GIF = 'gif';

    #[\Override]
    public function generate(MediaCollection $mediaCollection): MediaUrlCollection
    {
        $mediaUrlData = [];
        foreach ($mediaCollection as $mediaData) {
            if ($mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION] === self::FILE_EXTENSION_GIF) {
                $mediaUrlData[] = [
                    GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY],
                    GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY]
                ];
            }
        }

        return new MediaUrlCollection($mediaUrlData);
    }
}
