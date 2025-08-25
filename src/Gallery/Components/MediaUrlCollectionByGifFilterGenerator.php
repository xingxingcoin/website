<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use Xingxingcoin\Core\Gallery\MediaUrlCollectionByFilterGenerator;
use Xingxingcoin\Core\Gallery\Model\MediaCollection;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

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
