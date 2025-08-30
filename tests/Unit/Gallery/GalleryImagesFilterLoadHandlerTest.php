<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery;

use App\Database\Model\DocumentPath;
use App\Database\Model\Location;
use App\Database\Model\RootNavigation;
use App\Database\Model\SubNavigation;
use App\Gallery\GalleryImagesFilterLoadHandler;
use App\Tests\Unit\CustomTestCase;
use App\Tests\Unit\Gallery\Mocks\MediaCollectionByDocumentLoaderMock;
use App\Tests\Unit\Gallery\Mocks\MediaUrlCollectionByFilterGenerateHandlerMock;
use App\Tests\Unit\Gallery\Mocks\MediaUrlCollectionRandomizerMock;
use App\Tests\Unit\Mocks\DocumentByPathLoaderMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\DocumentManager\PathBuilder;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\ImageFilter;
use XingXingCoin\Core\Gallery\Model\MediaCollection;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

#[CoversClass(GalleryImagesFilterLoadHandler::class)]
#[UsesClass(Location::class)]
#[UsesClass(RootNavigation::class)]
#[UsesClass(SubNavigation::class)]
#[UsesClass(ImageFilter::class)]
#[UsesClass(DocumentPath::class)]
final class GalleryImagesFilterLoadHandlerTest extends CustomTestCase
{
    private MockObject $pathBuilderMock;
    private DocumentByPathLoaderMock $documentByPathLoaderMock;
    private MediaCollectionByDocumentLoaderMock $mediaCollectionByDocumentLoaderMock;
    private MediaUrlCollectionByFilterGenerateHandlerMock $mediaUrlCollectionByFilterGenerateHandlerMock;
    private MediaUrlCollectionRandomizerMock $mediaUrlCollectionRandomizerMock;
    private GalleryImagesFilterLoadHandler $galleryImagesFilterLoadHandler;

    protected function setUp(): void
    {
        $this->pathBuilderMock = $this->getMock(PathBuilder::class);
        $this->documentByPathLoaderMock = new DocumentByPathLoaderMock();
        $this->mediaCollectionByDocumentLoaderMock = new MediaCollectionByDocumentLoaderMock();
        $this->mediaUrlCollectionByFilterGenerateHandlerMock = new MediaUrlCollectionByFilterGenerateHandlerMock();
        $this->mediaUrlCollectionRandomizerMock = new MediaUrlCollectionRandomizerMock();
        $this->galleryImagesFilterLoadHandler = new GalleryImagesFilterLoadHandler(
            $this->pathBuilderMock,
            $this->documentByPathLoaderMock,
            $this->mediaCollectionByDocumentLoaderMock,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock,
            $this->mediaUrlCollectionRandomizerMock,
        );
    }

    public function testHandleWith30Urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedImageFilter = new ImageFilter('image');
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesFilterLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
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
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesFilterLoadHandler->handle(
            $expectedLocation,
            $expectedImageCounter,
            $expectedImageFilter,
        );

        self::assertSame($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaCollectionByDocumentLoaderMock->inputLocation);
        self::assertSame(
            $expectedMediaCollection,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputMediaCollection,
        );
        self::assertSame(
            $expectedImageFilter->value,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputImageFilter->value,
        );
        self::assertSame(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData,
        );
    }

    public function testHandleWith31Urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedImageFilter = new ImageFilter('image');
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesFilterLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
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
            'testUrl',
        ];
        $expectedMediaCollection = new MediaCollection($expectedMediaGroups);
        $this->mediaCollectionByDocumentLoaderMock->outputMediaCollection = $expectedMediaCollection;
        $expectedMediaUrlCollection = new MediaUrlCollection($expectedMediaGroups);
        $this->mediaUrlCollectionByFilterGenerateHandlerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
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
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = new MediaUrlCollection(
            $expectedMediaGroups,
        );

        $mediaUrlCollection = $this->galleryImagesFilterLoadHandler->handle(
            $expectedLocation,
            $expectedImageCounter,
            $expectedImageFilter,
        );

        self::assertSame($expectedMediaGroups, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaCollectionByDocumentLoaderMock->inputLocation);
        self::assertSame(
            $expectedMediaCollection,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputMediaCollection,
        );
        self::assertSame(
            $expectedImageFilter->value,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputImageFilter->value,
        );
        self::assertSame(
            $expectedMediaGroups,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData,
        );
    }

    public function testHandleWithCounterEqualsNegativeOne(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(-1);
        $expectedImageFilter = new ImageFilter('image');
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesFilterLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaCollection = new MediaCollection([]);
        $this->mediaCollectionByDocumentLoaderMock->outputMediaCollection = $expectedMediaCollection;
        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        $this->mediaUrlCollectionByFilterGenerateHandlerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesFilterLoadHandler->handle(
            $expectedLocation,
            $expectedImageCounter,
            $expectedImageFilter,
        );

        self::assertSame($expectedMediaCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaCollectionByDocumentLoaderMock->inputLocation);
        self::assertSame(
            $expectedMediaCollection,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputMediaCollection,
        );
        self::assertSame(
            $expectedImageFilter->value,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputImageFilter->value,
        );
        self::assertSame(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData,
        );
    }

    public function testHandleWithInvalidKey(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedImageFilter = new ImageFilter('image');
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesFilterLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaGroups = [
            1 => 'testUrl',
            2 => 'testUrl',
            3 => 'testUrl',
        ];
        $expectedMediaCollection = new MediaCollection($expectedMediaGroups);
        $this->mediaCollectionByDocumentLoaderMock->outputMediaCollection = $expectedMediaCollection;
        $expectedMediaUrlCollection = new MediaUrlCollection($expectedMediaGroups);
        $this->mediaUrlCollectionByFilterGenerateHandlerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = new MediaUrlCollection([]);

        $mediaUrlCollection = $this->galleryImagesFilterLoadHandler->handle(
            $expectedLocation,
            $expectedImageCounter,
            $expectedImageFilter,
        );

        $expectedMediaUrlGroups = [];
        self::assertSame($expectedMediaUrlGroups, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaCollectionByDocumentLoaderMock->inputLocation);
        self::assertSame(
            $expectedMediaCollection,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputMediaCollection,
        );
        self::assertSame(
            $expectedImageFilter->value,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputImageFilter->value,
        );
        self::assertSame(
            $expectedMediaUrlGroups,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData,
        );
    }
}
