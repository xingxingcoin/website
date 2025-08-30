<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components;

use App\Gallery\Components\GalleryMediaUrlCollectionByFilterGenerateHandler;
use App\Tests\Unit\Gallery\Components\Mocks\MediaUrlCollectionByFilterGeneratorMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use XingXingCoin\Core\Gallery\Model\ImageFilter;
use XingXingCoin\Core\Gallery\Model\MediaCollection;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

#[CoversClass(GalleryMediaUrlCollectionByFilterGenerateHandler::class)]
#[UsesClass(ImageFilter::class)]
final class GalleryMediaUrlCollectionByFilterGenerateHandlerTest extends TestCase
{
    private MediaUrlCollectionByFilterGeneratorMock $mediaUrlCollectionByAllImagesFilterGeneratorMock;
    private MediaUrlCollectionByFilterGeneratorMock $mediaUrlCollectionByGifFilterGeneratorMock;
    private GalleryMediaUrlCollectionByFilterGenerateHandler $mediaUrlCollectionByFilterGenerateHandler;

    protected function setUp(): void
    {
        $this->mediaUrlCollectionByAllImagesFilterGeneratorMock = new MediaUrlCollectionByFilterGeneratorMock();
        $this->mediaUrlCollectionByGifFilterGeneratorMock = new MediaUrlCollectionByFilterGeneratorMock();
        $this->mediaUrlCollectionByFilterGenerateHandler = new GalleryMediaUrlCollectionByFilterGenerateHandler(
            $this->mediaUrlCollectionByGifFilterGeneratorMock,
            $this->mediaUrlCollectionByAllImagesFilterGeneratorMock,
        );
    }

    public function testHandleWithGif(): void
    {
        $mediaCollection = new MediaCollection([]);
        $imageFilter = new ImageFilter(GalleryMediaUrlCollectionByFilterGenerateHandler::IMAGE_FILTER_GIF_VALUE);

        $mediaGifUrlCollection = new MediaUrlCollection(['test']);
        $this->mediaUrlCollectionByGifFilterGeneratorMock->outputMediaUrlCollection = $mediaGifUrlCollection;
        $mediaAllImagesUrlCollection = new MediaUrlCollection(['test2']);
        $this->mediaUrlCollectionByAllImagesFilterGeneratorMock->outputMediaUrlCollection = $mediaAllImagesUrlCollection;
        $mediaUrlCollection = $this->mediaUrlCollectionByFilterGenerateHandler->handle($mediaCollection, $imageFilter);

        self::assertEquals($mediaGifUrlCollection, $mediaUrlCollection);
        self::assertEquals($mediaCollection, $this->mediaUrlCollectionByGifFilterGeneratorMock->inputMediaCollection);
    }

    public function testHandleWithImage(): void
    {
        $mediaCollection = new MediaCollection([]);
        $imageFilter = new ImageFilter(GalleryMediaUrlCollectionByFilterGenerateHandler::IMAGE_FILTER_IMAGE_VALUE);

        $mediaGifUrlCollection = new MediaUrlCollection(['test']);
        $this->mediaUrlCollectionByGifFilterGeneratorMock->outputMediaUrlCollection = $mediaGifUrlCollection;
        $mediaAllImagesUrlCollection = new MediaUrlCollection(['test2']);
        $this->mediaUrlCollectionByAllImagesFilterGeneratorMock->outputMediaUrlCollection = $mediaAllImagesUrlCollection;
        $mediaUrlCollection = $this->mediaUrlCollectionByFilterGenerateHandler->handle($mediaCollection, $imageFilter);

        self::assertEquals($mediaAllImagesUrlCollection, $mediaUrlCollection);
        self::assertEquals(
            $mediaCollection,
            $this->mediaUrlCollectionByAllImagesFilterGeneratorMock->inputMediaCollection,
        );
    }

    public function testHandleWithInvalidImageFilter(): void
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
