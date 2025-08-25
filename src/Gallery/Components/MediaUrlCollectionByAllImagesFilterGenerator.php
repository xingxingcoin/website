<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use Xingxingcoin\Core\Gallery\MediaUrlCollectionByFilterGenerator;
use Xingxingcoin\Core\Gallery\Model\MediaCollection;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

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
            if ($mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION] === self::FILE_EXTENSION_JPG) {
                $mediaUrlData[] = [
                    GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY],
                    GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY]
                ];
            }
            if ($mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION] === self::FILE_EXTENSION_WEBP) {
                $mediaUrlData[] = [
                    GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY],
                    GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY]
                ];
            }
            if ($mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION] === self::FILE_EXTENSION_PNG) {
                $mediaUrlData[] = [
                    GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY],
                    GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY]
                ];
            }
        }

        return new MediaUrlCollection($mediaUrlData);
    }
}
