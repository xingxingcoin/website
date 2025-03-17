<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\MediaUrlCollection;

final readonly class MediaUrlCollectionByAllImagesFilterGenerator implements MediaUrlCollectionByFilterGenerator
{
    public const string FILE_EXTENSION_JPG = 'jpg';
    public const string FILE_EXTENSION_WEBP = 'webp';
    public const string FILE_EXTENSION_PNG = 'png';

    #[\Override]
    public function generate(MediaCollection $mediaCollection): MediaUrlCollection
    {
        $mediaUrlData = [];
        foreach ($mediaCollection as $mediaData) {
            if ($mediaData[MediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION] === self::FILE_EXTENSION_JPG) {
                $mediaUrlData[] = [
                    MediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => $mediaData[MediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY],
                    MediaCollectionByDocumentLoader::MEDIA_URL_KEY => $mediaData[MediaCollectionByDocumentLoader::MEDIA_URL_KEY]
                ];
            }
            if ($mediaData[MediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION] === self::FILE_EXTENSION_WEBP) {
                $mediaUrlData[] = [
                    MediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => $mediaData[MediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY],
                    MediaCollectionByDocumentLoader::MEDIA_URL_KEY => $mediaData[MediaCollectionByDocumentLoader::MEDIA_URL_KEY]
                ];
            }
            if ($mediaData[MediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION] === self::FILE_EXTENSION_PNG) {
                $mediaUrlData[] = [
                    MediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => $mediaData[MediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY],
                    MediaCollectionByDocumentLoader::MEDIA_URL_KEY => $mediaData[MediaCollectionByDocumentLoader::MEDIA_URL_KEY]
                ];
            }
        }

        return new MediaUrlCollection($mediaUrlData);
    }
}
