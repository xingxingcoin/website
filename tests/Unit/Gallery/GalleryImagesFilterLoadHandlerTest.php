<?php

namespace App\Tests\Unit\Gallery;

use App\Gallery\GalleryImagesFilterLoadHandler;
use App\Gallery\Model\ImageCounter;
use App\Gallery\Model\ImageFilter;
use App\Gallery\Model\Location;
use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\MediaUrlCollection;
use App\Gallery\Model\RootNavigation;
use App\Gallery\Model\SubNavigation;
use App\Tests\Unit\CustomTestCase;
use App\Tests\Unit\Gallery\Mocks\DocumentByPathLoaderMock;
use App\Tests\Unit\Gallery\Mocks\MediaCollectionByDocumentLoaderMock;
use App\Tests\Unit\Gallery\Mocks\MediaUrlCollectionByFilterGenerateHandlerMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\DocumentManager\PathBuilder;

#[CoversClass(GalleryImagesFilterLoadHandler::class)]
#[CoversClass(Location::class)]
#[CoversClass(RootNavigation::class)]
#[CoversClass(SubNavigation::class)]
#[CoversClass(ImageFilter::class)]
final class GalleryImagesFilterLoadHandlerTest extends CustomTestCase
{
    private MockObject $pathBuilderMock;
    private DocumentByPathLoaderMock $documentByPathLoaderMock;
    private MediaCollectionByDocumentLoaderMock $mediaCollectionByDocumentLoaderMock;
    private MediaUrlCollectionByFilterGenerateHandlerMock $mediaUrlCollectionByFilterGenerateHandlerMock;
    private GalleryImagesFilterLoadHandler $galleryImagesFilterLoadHandler;

    protected function setUp(): void
    {
        $this->pathBuilderMock = $this->getMock(PathBuilder::class);
        $this->documentByPathLoaderMock = new DocumentByPathLoaderMock();
        $this->mediaCollectionByDocumentLoaderMock = new MediaCollectionByDocumentLoaderMock();
        $this->mediaUrlCollectionByFilterGenerateHandlerMock = new MediaUrlCollectionByFilterGenerateHandlerMock();
        $this->galleryImagesFilterLoadHandler = new GalleryImagesFilterLoadHandler(
            $this->pathBuilderMock,
            $this->documentByPathLoaderMock,
            $this->mediaCollectionByDocumentLoaderMock,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock,
        );
    }

    public function testHandle_with_30_urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedImageFilter = new ImageFilter('image');
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesFilterLoadHandler::PATH])
            ->willReturn($expectedPath);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaGroups = [
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
        ];
        $expectedMediaCollection = new MediaCollection($expectedMediaGroups);
        $this->mediaCollectionByDocumentLoaderMock->outputMediaCollection = $expectedMediaCollection;
        $expectedMediaUrlCollection = new MediaUrlCollection($expectedMediaGroups);
        $this->mediaUrlCollectionByFilterGenerateHandlerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $mediaUrlCollection = $this->galleryImagesFilterLoadHandler->handle(
            $expectedLocation,
            $expectedImageCounter,
            $expectedImageFilter
        );

        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals($expectedMediaCollection, $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputMediaCollection);
        self::assertSame($expectedImageFilter->value, $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputImageFilter->value);
    }

    public function testHandle_with_31_urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedImageFilter = new ImageFilter('image');
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesFilterLoadHandler::PATH])
            ->willReturn($expectedPath);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaGroups = [
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl'
        ];
        $expectedMediaCollection = new MediaCollection($expectedMediaGroups);
        $this->mediaCollectionByDocumentLoaderMock->outputMediaCollection = $expectedMediaCollection;
        $expectedMediaUrlCollection = new MediaUrlCollection($expectedMediaGroups);
        $this->mediaUrlCollectionByFilterGenerateHandlerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesFilterLoadHandler->handle(
            $expectedLocation,
            $expectedImageCounter,
            $expectedImageFilter
        );

        $expectedMediaGroups = [
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl',
            'testUrl'
        ];
        self::assertEquals($expectedMediaGroups, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals($expectedMediaCollection, $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputMediaCollection);
        self::assertSame($expectedImageFilter->value, $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputImageFilter->value);
    }

    public function testHandle_with_counter_equals_negative_one(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(-1);
        $expectedImageFilter = new ImageFilter('image');
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesFilterLoadHandler::PATH])
            ->willReturn($expectedPath);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaCollection = new MediaCollection([]);
        $this->mediaCollectionByDocumentLoaderMock->outputMediaCollection = $expectedMediaCollection;
        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        $this->mediaUrlCollectionByFilterGenerateHandlerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesFilterLoadHandler->handle(
            $expectedLocation,
            $expectedImageCounter,
            $expectedImageFilter
        );

        self::assertEquals($expectedMediaCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals($expectedMediaCollection, $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputMediaCollection);
        self::assertSame($expectedImageFilter->value, $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputImageFilter->value);
    }

    public function testHandle_with_invalid_key(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedImageFilter = new ImageFilter('image');
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesFilterLoadHandler::PATH])
            ->willReturn($expectedPath);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaGroups = [
            1 => 'testUrl',
            2 => 'testUrl',
            3 => 'testUrl'
        ];
        $expectedMediaCollection = new MediaCollection($expectedMediaGroups);
        $this->mediaCollectionByDocumentLoaderMock->outputMediaCollection = $expectedMediaCollection;
        $expectedMediaUrlCollection = new MediaUrlCollection($expectedMediaGroups);
        $this->mediaUrlCollectionByFilterGenerateHandlerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesFilterLoadHandler->handle(
            $expectedLocation,
            $expectedImageCounter,
            $expectedImageFilter
        );

        $expectedMediaUrlGroups = [];
        self::assertEquals($expectedMediaUrlGroups, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals($expectedMediaCollection, $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputMediaCollection);
        self::assertSame($expectedImageFilter->value, $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputImageFilter->value);
    }
}
