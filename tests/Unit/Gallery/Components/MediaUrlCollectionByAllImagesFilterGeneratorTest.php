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

#[CoversClass(MediaUrlCollectionByAllImagesFilterGenerator::class)]
final class MediaUrlCollectionByAllImagesFilterGeneratorTest extends TestCase
{
    private MediaUrlCollectionByAllImagesFilterGenerator $mediaUrlCollectionByAllImagesFilterGenerator;

    protected function setUp(): void
    {
        $this->mediaUrlCollectionByAllImagesFilterGenerator = new MediaUrlCollectionByAllImagesFilterGenerator();
    }

    public function testGenerate_with_png(): void
    {
        $mediaCollection = new MediaCollection([
            [
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByAllImagesFilterGenerator::FILE_EXTENSION_PNG,
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl',
            ],
            [
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByGifFilterGenerator::FILE_EXTENSION_GIF,
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl2',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl2',
            ],
            [
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByAllImagesFilterGenerator::FILE_EXTENSION_PNG,
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl3',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl3',
            ],
        ]);

        $mediaUrlCollection = $this->mediaUrlCollectionByAllImagesFilterGenerator->generate($mediaCollection);

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

    public function testGenerate_with_webp(): void
    {
        $mediaCollection = new MediaCollection([
            [
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByAllImagesFilterGenerator::FILE_EXTENSION_WEBP,
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl',
            ],
            [
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByGifFilterGenerator::FILE_EXTENSION_GIF,
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl2',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl2',
            ],
            [
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByAllImagesFilterGenerator::FILE_EXTENSION_WEBP,
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl3',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl3',
            ],
        ]);

        $mediaUrlCollection = $this->mediaUrlCollectionByAllImagesFilterGenerator->generate($mediaCollection);

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

    public function testGenerate_with_jpg(): void
    {
        $mediaCollection = new MediaCollection([
            [
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByAllImagesFilterGenerator::FILE_EXTENSION_JPG,
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl',
            ],
            [
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByGifFilterGenerator::FILE_EXTENSION_GIF,
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl2',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl2',
            ],
            [
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByAllImagesFilterGenerator::FILE_EXTENSION_JPG,
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl3',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl3',
            ],
        ]);

        $mediaUrlCollection = $this->mediaUrlCollectionByAllImagesFilterGenerator->generate($mediaCollection);

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
        $mediaUrlCollection = $this->mediaUrlCollectionByAllImagesFilterGenerator->generate($mediaCollection);

        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        self::assertEquals($expectedMediaUrlCollection, $mediaUrlCollection);
    }
}
