<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery;

use App\Database\Model\DocumentPath;
use App\Gallery\GalleryImagesLoadHandler;
use App\Tests\Unit\CustomTestCase;
use App\Tests\Unit\Gallery\Mocks\MediaUrlCollectionByDocumentLoaderMock;
use App\Tests\Unit\Gallery\Mocks\MediaUrlCollectionRandomizerMock;
use App\Tests\Unit\Mocks\DocumentByPathLoaderMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\DocumentManager\PathBuilder;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use App\Model\Location;

#[CoversClass(GalleryImagesLoadHandler::class)]
#[CoversClass(Location::class)]
#[CoversClass(RootNavigation::class)]
#[CoversClass(SubNavigation::class)]
#[CoversClass(DocumentPath::class)]
final class GalleryImagesLoadHandlerTest extends CustomTestCase
{
    private MockObject $pathBuilderMock;
    private DocumentByPathLoaderMock $documentByPathLoaderMock;
    private MediaUrlCollectionByDocumentLoaderMock $mediaUrlCollectionByDocumentLoaderMock;
    private MediaUrlCollectionRandomizerMock $mediaUrlCollectionRandomizerMock;
    private GalleryImagesLoadHandler $galleryImagesLoadHandler;

    protected function setUp(): void
    {
        $this->pathBuilderMock = $this->getMock(PathBuilder::class);
        $this->documentByPathLoaderMock = new DocumentByPathLoaderMock();
        $this->mediaUrlCollectionByDocumentLoaderMock = new MediaUrlCollectionByDocumentLoaderMock();
        $this->mediaUrlCollectionRandomizerMock = new MediaUrlCollectionRandomizerMock();
        $this->galleryImagesLoadHandler = new GalleryImagesLoadHandler(
            $this->pathBuilderMock,
            $this->documentByPathLoaderMock,
            $this->mediaUrlCollectionByDocumentLoaderMock,
            $this->mediaUrlCollectionRandomizerMock,
        );
    }

    public function testHandle_is_valid(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlCollection = new MediaUrlCollection(['testUrl', 'testUrl']);
        $this->mediaUrlCollectionByDocumentLoaderMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );
    }

    public function testHandle_with_30_urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
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
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );
    }

    public function testHandle_with_31_urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
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
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = new MediaUrlCollection(
            $expectedMediaUrlGroups
        );

        $mediaUrlCollection = $this->galleryImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertEquals($expectedMediaUrlGroups, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals(
            $expectedMediaUrlGroups,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );
    }

    public function testHandle_with_counter_equals_negative_one(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(-1);
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        $this->mediaUrlCollectionByDocumentLoaderMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->galleryImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );
    }

    public function testHandle_with_invalid_key(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', GalleryImagesLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlGroups = [
            1 => 'testUrl',
            2 => 'testUrl',
            3 => 'testUrl'
        ];
        $expectedMediaUrlCollection = new MediaUrlCollection($expectedMediaUrlGroups);
        $this->mediaUrlCollectionByDocumentLoaderMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = new MediaUrlCollection([]);

        $mediaUrlCollection = $this->galleryImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        $expectedMediaUrlGroups = [];
        self::assertEquals($expectedMediaUrlGroups, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals(
            $expectedMediaUrlGroups,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );
    }
}
