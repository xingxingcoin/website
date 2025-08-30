<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components;

use App\Gallery\Components\MemeGeneratorMediaUrlCollectionByFilterGenerateHandler;
use App\Tests\Unit\Gallery\Components\Mocks\MediaUrlCollectionByFilterGeneratorMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use XingXingCoin\Core\Gallery\Model\ImageFilter;
use XingXingCoin\Core\Gallery\Model\MediaCollection;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

#[CoversClass(MemeGeneratorMediaUrlCollectionByFilterGenerateHandler::class)]
#[UsesClass(ImageFilter::class)]
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
            $this->mediaUrlCollectionByAllImagesFilterGeneratorMock,
        );
    }

    public function testHandleWithMemeTemplate(): void
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

    public function testHandleWithMemeImage(): void
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
