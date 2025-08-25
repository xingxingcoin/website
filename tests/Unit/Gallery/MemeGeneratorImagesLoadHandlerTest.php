<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery;

use App\Gallery\MemeGeneratorImagesLoadHandler;
use App\Tests\Unit\CustomTestCase;
use App\Tests\Unit\Gallery\Mocks\MediaUrlCollectionByDocumentLoaderMock;
use App\Tests\Unit\Gallery\Mocks\MediaUrlCollectionRandomizerMock;
use App\Tests\Unit\Mocks\DocumentByPathLoaderMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\DocumentManager\PathBuilder;
use Xingxingcoin\Core\Gallery\Model\ImageCounter;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;
use Xingxingcoin\Core\Gallery\Model\RootNavigation;
use Xingxingcoin\Core\Gallery\Model\SubNavigation;
use Xingxingcoin\Core\Model\Location;

#[CoversClass(MemeGeneratorImagesLoadHandler::class)]
#[CoversClass(Location::class)]
#[CoversClass(RootNavigation::class)]
#[CoversClass(SubNavigation::class)]
final class MemeGeneratorImagesLoadHandlerTest extends CustomTestCase
{
    private MockObject $pathBuilderMock;
    private DocumentByPathLoaderMock $documentByPathLoaderMock;
    private MediaUrlCollectionByDocumentLoaderMock $mediaUrlCollectionByDocumentConverterMock;
    private MediaUrlCollectionRandomizerMock $mediaUrlCollectionRandomizerMock;
    private MemeGeneratorImagesLoadHandler $memeGeneratorImagesLoadHandler;

    protected function setUp(): void
    {
        $this->pathBuilderMock = $this->getMock(PathBuilder::class);
        $this->documentByPathLoaderMock = new DocumentByPathLoaderMock();
        $this->mediaUrlCollectionByDocumentConverterMock = new MediaUrlCollectionByDocumentLoaderMock();
        $this->mediaUrlCollectionRandomizerMock = new MediaUrlCollectionRandomizerMock();
        $this->memeGeneratorImagesLoadHandler = new MemeGeneratorImagesLoadHandler(
            $this->pathBuilderMock,
            $this->documentByPathLoaderMock,
            $this->mediaUrlCollectionByDocumentConverterMock,
            $this->mediaUrlCollectionRandomizerMock,
        );
    }

    public function testHandle_is_valid(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesLoadHandler::PATH])
            ->willReturn($expectedPath);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlCollection = new MediaUrlCollection(['testUrl', 'testUrl']);
        $this->mediaUrlCollectionByDocumentConverterMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->memeGeneratorImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentConverterMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentConverterMock->inputLocation);
        self::assertEquals(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );
    }

    public function testHandle_with_30_urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesLoadHandler::PATH])
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
        $this->mediaUrlCollectionByDocumentConverterMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->memeGeneratorImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentConverterMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentConverterMock->inputLocation);
        self::assertEquals(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );
    }

    public function testHandle_with_31_urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesLoadHandler::PATH])
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
        $this->mediaUrlCollectionByDocumentConverterMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
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
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = new MediaUrlCollection($expectedMediaUrlGroups);

        $mediaUrlCollection = $this->memeGeneratorImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertEquals($expectedMediaUrlGroups, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentConverterMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentConverterMock->inputLocation);
        self::assertEquals(
            $expectedMediaUrlGroups,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );
    }

    public function testHandle_with_counter_equals_negative_one(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(-1);
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesLoadHandler::PATH])
            ->willReturn($expectedPath);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        $this->mediaUrlCollectionByDocumentConverterMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->memeGeneratorImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentConverterMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentConverterMock->inputLocation);
        self::assertEquals(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );;
    }

    public function testHandle_with_invalid_key(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesLoadHandler::PATH])
            ->willReturn($expectedPath);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlGroups = [
            1 => 'testUrl',
            2 => 'testUrl',
            3 => 'testUrl'
        ];
        $expectedMediaUrlCollection = new MediaUrlCollection($expectedMediaUrlGroups);
        $this->mediaUrlCollectionByDocumentConverterMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = new MediaUrlCollection([]);

        $mediaUrlCollection = $this->memeGeneratorImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        $expectedMediaUrlGroups = [];
        self::assertEquals($expectedMediaUrlGroups, $mediaUrlCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentConverterMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentConverterMock->inputLocation);
        self::assertEquals(
            $expectedMediaUrlGroups,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData
        );
    }
}
