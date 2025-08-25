<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components;

use App\Gallery\Components\GalleryMediaUrlCollectionByFilterGenerateHandler;
use App\Tests\Unit\Gallery\Components\Mocks\MediaUrlCollectionByFilterGeneratorMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Xingxingcoin\Core\Gallery\Model\ImageFilter;
use Xingxingcoin\Core\Gallery\Model\MediaCollection;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

#[CoversClass(GalleryMediaUrlCollectionByFilterGenerateHandler::class)]
#[CoversClass(ImageFilter::class)]
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
            $this->mediaUrlCollectionByAllImagesFilterGeneratorMock
        );
    }

    public function testHandle_with_gif(): void
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

    public function testHandle_with_image(): void
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
            $this->mediaUrlCollectionByAllImagesFilterGeneratorMock->inputMediaCollection
        );
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
