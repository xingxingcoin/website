<?php

namespace App\Tests\Unit\Gallery\Components;

use App\Gallery\Components\MediaUrlCollectionByMemeImageFilterGenerator;
use App\Gallery\Components\MemeGeneratorMediaCollectionByDocumentLoader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Xingxingcoin\Core\Gallery\Model\MediaCollection;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

#[CoversClass(MediaUrlCollectionByMemeImageFilterGenerator::class)]
final class MediaUrlCollectionByMemeImageFilterGeneratorTest extends TestCase
{
    private MediaUrlCollectionByMemeImageFilterGenerator $mediaUrlCollectionByMemeImageFilterGenerator;

    protected function setUp(): void
    {
        $this->mediaUrlCollectionByMemeImageFilterGenerator = new MediaUrlCollectionByMemeImageFilterGenerator();
    }

    public function testGenerate_is_valid(): void
    {
        $mediaCollection = new MediaCollection([
            [
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_NAME_KEY => 'image.jpg',
                MemeGeneratorMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl',
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl',
            ],
            [
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_NAME_KEY => 'template.jpg',
                MemeGeneratorMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl2',
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl2',
            ],
            [
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_NAME_KEY => 'image.jpg',
                MemeGeneratorMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl3',
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl3',
            ],
        ]);

        $mediaUrlCollection = $this->mediaUrlCollectionByMemeImageFilterGenerator->generate($mediaCollection);

        $expectedMediaUrlCollection = new MediaUrlCollection([
            [
                MemeGeneratorMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl',
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl'
            ],
            [
                MemeGeneratorMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl3',
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl3'
            ]
        ]);
        self::assertEquals($expectedMediaUrlCollection, $mediaUrlCollection);
    }

    public function testGenerate_is_empty(): void
    {
        $mediaCollection = new MediaCollection([]);
        $mediaUrlCollection = $this->mediaUrlCollectionByMemeImageFilterGenerator->generate($mediaCollection);

        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        self::assertEquals($expectedMediaUrlCollection, $mediaUrlCollection);
    }
}
