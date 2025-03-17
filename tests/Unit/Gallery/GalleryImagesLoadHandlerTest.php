<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery;

use App\Gallery\GalleryImagesLoadHandler;
use App\Gallery\Model\ImageCounter;
use App\Gallery\Model\Location;
use App\Gallery\Model\MediaUrlCollection;
use App\Gallery\Model\RootNavigation;
use App\Gallery\Model\SubNavigation;
use App\Tests\Unit\CustomTestCase;
use App\Tests\Unit\Gallery\Mocks\DocumentByPathLoaderMock;
use App\Tests\Unit\Gallery\Mocks\MediaUrlCollectionByDocumentLoaderMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\DocumentManager\PathBuilder;

#[CoversClass(GalleryImagesLoadHandler::class)]
#[CoversClass(Location::class)]
#[CoversClass(RootNavigation::class)]
#[CoversClass(SubNavigation::class)]
final class GalleryImagesLoadHandlerTest extends CustomTestCase
{
    private MockObject $pathBuilderMock;
    private DocumentByPathLoaderMock $documentByPathLoaderMock;
    private MediaUrlCollectionByDocumentLoaderMock $mediaUrlCollectionByDocumentLoaderMock;
    private GalleryImagesLoadHandler $galleryImagesLoadHandler;

    protected function setUp(): void
    {
        $this->pathBuilderMock = $this->getMock(PathBuilder::class);
        $this->documentByPathLoaderMock = new DocumentByPathLoaderMock();
        $this->mediaUrlCollectionByDocumentLoaderMock = new MediaUrlCollectionByDocumentLoaderMock();
        $this->galleryImagesLoadHandler = new GalleryImagesLoadHandler(
            $this->pathBuilderMock,
            $this->documentByPathLoaderMock,
            $this->mediaUrlCollectionByDocumentLoaderMock
        );
    }

    public function testHandle_is_valid(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesLoadHandler::PATH])
            ->willReturn($expectedPath);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlCollection = new MediaUrlCollection(['testUrl', 'testUrl']);
        $this->mediaUrlCollectionByDocumentLoaderMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentLoaderMock->inputLocation);
    }

    public function testHandle_with_30_urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesLoadHandler::PATH])
            ->willReturn($expectedPath);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlGroups = [
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
        $expectedMediaUrlCollection = new MediaUrlCollection($expectedMediaUrlGroups);
        $this->mediaUrlCollectionByDocumentLoaderMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentLoaderMock->inputLocation);
    }

    public function testHandle_with_31_urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesLoadHandler::PATH])
            ->willReturn($expectedPath);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlGroups = [
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
        $expectedMediaUrlCollection = new MediaUrlCollection($expectedMediaUrlGroups);
        $this->mediaUrlCollectionByDocumentLoaderMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        $expectedMediaUrlGroups = [
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
        self::assertEquals($expectedMediaUrlGroups, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentLoaderMock->inputLocation);
    }

    public function testHandle_with_counter_equals_negative_one(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(-1);
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesLoadHandler::PATH])
            ->willReturn($expectedPath);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        $this->mediaUrlCollectionByDocumentLoaderMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentLoaderMock->inputLocation);
    }

    public function testHandle_with_invalid_key(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesLoadHandler::PATH])
            ->willReturn($expectedPath);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlGroups = [
            1 => 'testUrl',
            2 => 'testUrl',
            3 => 'testUrl'
        ];
        $expectedMediaUrlCollection = new MediaUrlCollection($expectedMediaUrlGroups);
        $this->mediaUrlCollectionByDocumentLoaderMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        $expectedMediaUrlGroups = [];
        self::assertEquals($expectedMediaUrlGroups, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentLoaderMock->inputLocation);
    }
}
