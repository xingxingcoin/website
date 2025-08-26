<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery;

use App\Gallery\MemeGeneratorImagesFilterLoadHandler;
use App\Tests\Unit\CustomTestCase;
use App\Tests\Unit\Gallery\Mocks\MediaCollectionByDocumentLoaderMock;
use App\Tests\Unit\Gallery\Mocks\MediaUrlCollectionByFilterGenerateHandlerMock;
use App\Tests\Unit\Gallery\Mocks\MediaUrlCollectionRandomizerMock;
use App\Tests\Unit\Mocks\DocumentByPathLoaderMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\DocumentManager\PathBuilder;
use XingXingCoin\Core\Database\Model\DocumentPath;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\ImageFilter;
use XingXingCoin\Core\Gallery\Model\MediaCollection;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use XingXingCoin\Core\Model\Location;

#[CoversClass(MemeGeneratorImagesFilterLoadHandler::class)]
#[CoversClass(Location::class)]
#[CoversClass(RootNavigation::class)]
#[CoversClass(SubNavigation::class)]
#[CoversClass(ImageFilter::class)]
#[CoversClass(DocumentPath::class)]
final class MemeGeneratorImagesFilterLoadHandlerTest extends CustomTestCase
{
    private MockObject $pathBuilderMock;
    private DocumentByPathLoaderMock $documentByPathLoaderMock;
    private MediaCollectionByDocumentLoaderMock $mediaCollectionByDocumentLoaderMock;
    private MediaUrlCollectionByFilterGenerateHandlerMock $mediaUrlCollectionByFilterGenerateHandlerMock;
    private MediaUrlCollectionRandomizerMock $mediaUrlCollectionRandomizerMock;
    private MemeGeneratorImagesFilterLoadHandler $memeGeneratorImagesFilterLoadHandler;

    protected function setUp(): void
    {
        $this->pathBuilderMock = $this->getMock(PathBuilder::class);
        $this->documentByPathLoaderMock = new DocumentByPathLoaderMock();
        $this->mediaCollectionByDocumentLoaderMock = new MediaCollectionByDocumentLoaderMock();
        $this->mediaUrlCollectionByFilterGenerateHandlerMock = new MediaUrlCollectionByFilterGenerateHandlerMock();
        $this->mediaUrlCollectionRandomizerMock = new MediaUrlCollectionRandomizerMock();
        $this->memeGeneratorImagesFilterLoadHandler = new MemeGeneratorImagesFilterLoadHandler(
            $this->pathBuilderMock,
            $this->documentByPathLoaderMock,
            $this->mediaCollectionByDocumentLoaderMock,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock,
            $this->mediaUrlCollectionRandomizerMock,
        );
    }

    public function testHandle_with_30_urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedImageFilter = new ImageFilter('image');
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesFilterLoadHandler::PATH])
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
        $mediaUrlCollection = $this->memeGeneratorImagesFilterLoadHandler->handle(
            $expectedLocation,
            $expectedImageCounter,
            $expectedImageFilter
        );

        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals(
            $expectedMediaCollection,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputMediaCollection
        );
        self::assertSame(
            $expectedImageFilter->value,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputImageFilter->value
        );
        self::assertEquals(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );
    }

    public function testHandle_with_31_urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedImageFilter = new ImageFilter('image');
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesFilterLoadHandler::PATH])
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
            'testUrl'
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
            'testUrl'
        ];
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = new MediaUrlCollection(
            $expectedMediaGroups
        );

        $mediaUrlCollection = $this->memeGeneratorImagesFilterLoadHandler->handle(
            $expectedLocation,
            $expectedImageCounter,
            $expectedImageFilter
        );

        self::assertEquals($expectedMediaGroups, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals(
            $expectedMediaCollection,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputMediaCollection
        );
        self::assertSame(
            $expectedImageFilter->value,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputImageFilter->value
        );
        self::assertEquals(
            $expectedMediaGroups,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );;
    }

    public function testHandle_with_counter_equals_negative_one(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(-1);
        $expectedImageFilter = new ImageFilter('image');
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesFilterLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaCollection = new MediaCollection([]);
        $this->mediaCollectionByDocumentLoaderMock->outputMediaCollection = $expectedMediaCollection;
        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        $this->mediaUrlCollectionByFilterGenerateHandlerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->memeGeneratorImagesFilterLoadHandler->handle(
            $expectedLocation,
            $expectedImageCounter,
            $expectedImageFilter
        );

        self::assertEquals($expectedMediaCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals(
            $expectedMediaCollection,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputMediaCollection
        );
        self::assertSame(
            $expectedImageFilter->value,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputImageFilter->value
        );
        self::assertEquals(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );
    }

    public function testHandle_with_invalid_key(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedImageFilter = new ImageFilter('image');
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesFilterLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
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
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = new MediaUrlCollection([]);

        $mediaUrlCollection = $this->memeGeneratorImagesFilterLoadHandler->handle(
            $expectedLocation,
            $expectedImageCounter,
            $expectedImageFilter
        );

        $expectedMediaUrlGroups = [];
        self::assertEquals($expectedMediaUrlGroups, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaCollectionByDocumentLoaderMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaCollectionByDocumentLoaderMock->inputLocation);
        self::assertEquals(
            $expectedMediaCollection,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputMediaCollection
        );
        self::assertSame(
            $expectedImageFilter->value,
            $this->mediaUrlCollectionByFilterGenerateHandlerMock->inputImageFilter->value
        );
        self::assertEquals(
            $expectedMediaUrlGroups,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );
    }
}
