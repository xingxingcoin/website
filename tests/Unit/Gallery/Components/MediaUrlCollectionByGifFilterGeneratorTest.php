<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components;

use App\Gallery\Components\GalleryMediaCollectionByDocumentLoader;
use App\Gallery\Components\MediaUrlCollectionByAllImagesFilterGenerator;
use App\Gallery\Components\MediaUrlCollectionByGifFilterGenerator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Xingxingcoin\Core\Gallery\Model\MediaCollection;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

#[CoversClass(MediaUrlCollectionByGifFilterGenerator::class)]
final class MediaUrlCollectionByGifFilterGeneratorTest extends TestCase
{
    private MediaUrlCollectionByGifFilterGenerator $mediaUrlCollectionByGifFilterGenerator;

    protected function setUp(): void
    {
        $this->mediaUrlCollectionByGifFilterGenerator = new MediaUrlCollectionByGifFilterGenerator();
    }

    public function testGenerate_is_valid(): void
    {
        $mediaCollection = new MediaCollection([
            [
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByGifFilterGenerator::FILE_EXTENSION_GIF,
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl',
            ],
            [
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByAllImagesFilterGenerator::FILE_EXTENSION_JPG,
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl2',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl2',
            ],
            [
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByGifFilterGenerator::FILE_EXTENSION_GIF,
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl3',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl3',
            ],
        ]);

        $mediaUrlCollection = $this->mediaUrlCollectionByGifFilterGenerator->generate($mediaCollection);

        $expectedMediaUrlCollection = new MediaUrlCollection([
            [
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl'
            ],
            [
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl3',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl3'
            ]
        ]);
        self::assertEquals($expectedMediaUrlCollection, $mediaUrlCollection);
    }

    public function testGenerate_is_empty(): void
    {
        $mediaCollection = new MediaCollection([]);
        $mediaUrlCollection = $this->mediaUrlCollectionByGifFilterGenerator->generate($mediaCollection);

        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        self::assertEquals($expectedMediaUrlCollection, $mediaUrlCollection);
    }
}
