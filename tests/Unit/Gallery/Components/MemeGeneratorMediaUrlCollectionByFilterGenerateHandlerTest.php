<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components;

use App\Gallery\Components\MemeGeneratorMediaUrlCollectionByFilterGenerateHandler;
use App\Gallery\Model\ImageFilter;
use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\MediaUrlCollection;
use App\Tests\Unit\Gallery\Components\Mocks\MediaUrlCollectionByFilterGeneratorMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MemeGeneratorMediaUrlCollectionByFilterGenerateHandler::class)]
#[CoversClass(ImageFilter::class)]
final class MemeGeneratorMediaUrlCollectionByFilterGenerateHandlerTest extends TestCase
{
    private MediaUrlCollectionByFilterGeneratorMock $mediaUrlCollectionByAllImagesFilterGeneratorMock;
    private MediaUrlCollectionByFilterGeneratorMock $mediaUrlCollectionByGifFilterGeneratorMock;
    private MemeGeneratorMediaUrlCollectionByFilterGenerateHandler $mediaUrlCollectionByFilterGenerateHandler;

    protected function setUp(): void
    {
        $this->mediaUrlCollectionByAllImagesFilterGeneratorMock = new MediaUrlCollectionByFilterGeneratorMock();
        $this->mediaUrlCollectionByGifFilterGeneratorMock = new MediaUrlCollectionByFilterGeneratorMock();
        $this->mediaUrlCollectionByFilterGenerateHandler = new MemeGeneratorMediaUrlCollectionByFilterGenerateHandler(
            $this->mediaUrlCollectionByGifFilterGeneratorMock,
            $this->mediaUrlCollectionByAllImagesFilterGeneratorMock
        );
    }

    public function testHandle_with_meme_template(): void
    {
        $mediaCollection = new MediaCollection([]);
        $imageFilter = new ImageFilter(MemeGeneratorMediaUrlCollectionByFilterGenerateHandler::IMAGE_FILTER_TEMPLATE_VALUE);

        $mediaGifUrlCollection = new MediaUrlCollection(['test']);
        $this->mediaUrlCollectionByGifFilterGeneratorMock->outputMediaUrlCollection = $mediaGifUrlCollection;
        $mediaAllImagesUrlCollection = new MediaUrlCollection(['test2']);
        $this->mediaUrlCollectionByAllImagesFilterGeneratorMock->outputMediaUrlCollection = $mediaAllImagesUrlCollection;
        $mediaUrlCollection = $this->mediaUrlCollectionByFilterGenerateHandler->handle($mediaCollection, $imageFilter);

        self::assertEquals($mediaGifUrlCollection, $mediaUrlCollection);
        self::assertEquals($mediaCollection, $this->mediaUrlCollectionByGifFilterGeneratorMock->inputMediaCollection);
    }

    public function testHandle_with_meme_image(): void
    {
        $mediaCollection = new MediaCollection([]);
        $imageFilter = new ImageFilter(MemeGeneratorMediaUrlCollectionByFilterGenerateHandler::IMAGE_FILTER_IMAGE_VALUE);

        $mediaGifUrlCollection = new MediaUrlCollection(['test']);
        $this->mediaUrlCollectionByGifFilterGeneratorMock->outputMediaUrlCollection = $mediaGifUrlCollection;
        $mediaAllImagesUrlCollection = new MediaUrlCollection(['test2']);
        $this->mediaUrlCollectionByAllImagesFilterGeneratorMock->outputMediaUrlCollection = $mediaAllImagesUrlCollection;
        $mediaUrlCollection = $this->mediaUrlCollectionByFilterGenerateHandler->handle($mediaCollection, $imageFilter);

        self::assertEquals($mediaAllImagesUrlCollection, $mediaUrlCollection);
        self::assertEquals($mediaCollection, $this->mediaUrlCollectionByAllImagesFilterGeneratorMock->inputMediaCollection);
    }

    public function testHandle_with_invalid_image_filter(): void
    {
        $mediaCollection = new MediaCollection([]);
        $imageFilter = new ImageFilter('invalid');

        $mediaGifUrlCollection = new MediaUrlCollection(['test']);
        $this->mediaUrlCollectionByGifFilterGeneratorMock->outputMediaUrlCollection = $mediaGifUrlCollection;
        $mediaAllImagesUrlCollection = new MediaUrlCollection(['test2']);
        $this->mediaUrlCollectionByAllImagesFilterGeneratorMock->outputMediaUrlCollection = $mediaAllImagesUrlCollection;
        $mediaUrlCollection = $this->mediaUrlCollectionByFilterGenerateHandler->handle($mediaCollection, $imageFilter);

        self::assertEquals(new MediaUrlCollection([]), $mediaUrlCollection);
    }
}
