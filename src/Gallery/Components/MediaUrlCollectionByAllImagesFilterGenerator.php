<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use XingXingCoin\Core\Gallery\MediaUrlCollectionByFilterGenerator;
use XingXingCoin\Core\Gallery\Model\MediaCollection;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

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
            if (self::FILE_EXTENSION_JPG === $mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION]) {
                $mediaUrlData[] = [
                    GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY],
                    GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY],
                ];
            }
            if (self::FILE_EXTENSION_WEBP === $mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION]) {
                $mediaUrlData[] = [
                    GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY],
                    GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY],
                ];
            }
            if (self::FILE_EXTENSION_PNG === $mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION]) {
                $mediaUrlData[] = [
                    GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY],
                    GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => $mediaData[GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY],
                ];
            }
        }

        return new MediaUrlCollection($mediaUrlData);
    }
}
