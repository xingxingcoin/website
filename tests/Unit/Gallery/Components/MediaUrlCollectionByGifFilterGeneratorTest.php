<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components;

use App\Gallery\Components\MediaCollectionByDocumentLoader;
use App\Gallery\Components\MediaUrlCollectionByAllImagesFilterGenerator;
use App\Gallery\Components\MediaUrlCollectionByGifFilterGenerator;
use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\MediaUrlCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

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
                MediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByGifFilterGenerator::FILE_EXTENSION_GIF,
                MediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl',
                MediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl',
            ],
            [
                MediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByAllImagesFilterGenerator::FILE_EXTENSION_JPG,
                MediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl2',
                MediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl2',
            ],
            [
                MediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => MediaUrlCollectionByGifFilterGenerator::FILE_EXTENSION_GIF,
                MediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl3',
                MediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl3',
            ],
        ]);

        $mediaUrlCollection = $this->mediaUrlCollectionByGifFilterGenerator->generate($mediaCollection);

        $expectedMediaUrlCollection = new MediaUrlCollection([
            [
                MediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY  =>'testImageViewerUrl',
                MediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl'
            ],
            [
                MediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY  =>'testImageViewerUrl3',
                MediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl3'
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
