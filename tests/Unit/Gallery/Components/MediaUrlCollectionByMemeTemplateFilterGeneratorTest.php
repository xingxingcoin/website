<?php

namespace App\Tests\Unit\Gallery\Components;

use App\Gallery\Components\MediaUrlCollectionByMemeTemplateFilterGenerator;
use App\Gallery\Components\MemeGeneratorMediaCollectionByDocumentLoader;
use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\MediaUrlCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MediaUrlCollectionByMemeTemplateFilterGenerator::class)]
final class MediaUrlCollectionByMemeTemplateFilterGeneratorTest extends TestCase
{
    private MediaUrlCollectionByMemeTemplateFilterGenerator $mediaUrlCollectionByMemeTemplateFilterGenerator;

    protected function setUp(): void
    {
        $this->mediaUrlCollectionByMemeTemplateFilterGenerator = new MediaUrlCollectionByMemeTemplateFilterGenerator();
    }

    public function testGenerate_is_valid(): void
    {
        $mediaCollection = new MediaCollection([
            [
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_NAME_KEY => 'template.jpg',
                MemeGeneratorMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl',
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl',
            ],
            [
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_NAME_KEY => 'image.jpg',
                MemeGeneratorMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl2',
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl2',
            ],
            [
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_NAME_KEY => 'template.jpg',
                MemeGeneratorMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testImageViewerUrl3',
                MemeGeneratorMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testMediaUrl3',
            ],
        ]);

        $mediaUrlCollection = $this->mediaUrlCollectionByMemeTemplateFilterGenerator->generate($mediaCollection);

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
        $mediaUrlCollection = $this->mediaUrlCollectionByMemeTemplateFilterGenerator->generate($mediaCollection);

        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        self::assertEquals($expectedMediaUrlCollection, $mediaUrlCollection);
    }
}
