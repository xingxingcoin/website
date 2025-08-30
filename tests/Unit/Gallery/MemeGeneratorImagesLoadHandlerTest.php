<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery;

use App\Database\Model\DocumentPath;
use App\Database\Model\Location;
use App\Database\Model\RootNavigation;
use App\Database\Model\SubNavigation;
use App\Gallery\MemeGeneratorImagesLoadHandler;
use App\Tests\Unit\CustomTestCase;
use App\Tests\Unit\Gallery\Mocks\MediaUrlCollectionByDocumentLoaderMock;
use App\Tests\Unit\Gallery\Mocks\MediaUrlCollectionRandomizerMock;
use App\Tests\Unit\Mocks\DocumentByPathLoaderMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\DocumentManager\PathBuilder;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

#[CoversClass(MemeGeneratorImagesLoadHandler::class)]
#[UsesClass(Location::class)]
#[UsesClass(RootNavigation::class)]
#[UsesClass(SubNavigation::class)]
#[UsesClass(DocumentPath::class)]
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

    public function testHandleIsValid(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlCollection = new MediaUrlCollection(['testUrl', 'testUrl']);
        $this->mediaUrlCollectionByDocumentConverterMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->memeGeneratorImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertSame($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentConverterMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentConverterMock->inputLocation);
        self::assertSame(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData,
        );
    }

    public function testHandleWith30Urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesLoadHandler::PATH])
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
        $this->mediaUrlCollectionByDocumentConverterMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->memeGeneratorImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertSame($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentConverterMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentConverterMock->inputLocation);
        self::assertSame(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData,
        );
    }

    public function testHandleWith31Urls(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesLoadHandler::PATH])
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
            'testUrl',
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
            'testUrl',
        ];
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = new MediaUrlCollection(
            $expectedMediaUrlGroups,
        );

        $mediaUrlCollection = $this->memeGeneratorImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertSame($expectedMediaUrlGroups, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentConverterMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentConverterMock->inputLocation);
        self::assertSame(
            $expectedMediaUrlGroups,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData,
        );
    }

    public function testHandleWithCounterEqualsNegativeOne(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(-1);
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        $this->mediaUrlCollectionByDocumentConverterMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = $expectedMediaUrlCollection;

        $mediaUrlCollection = $this->memeGeneratorImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        self::assertSame($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentConverterMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentConverterMock->inputLocation);
        self::assertSame(
            $expectedMediaUrlCollection->data,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData,
        );
    }

    public function testHandleWithInvalidKey(): void
    {
        $expectedLocation = new Location('en');
        $expectedImageCounter = new ImageCounter(0);
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%', MemeGeneratorImagesLoadHandler::PATH])
            ->willReturn($expectedDocumentPath->value);
        $expectedPageDocument = new BasePageDocument();
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedMediaUrlGroups = [
            1 => 'testUrl',
            2 => 'testUrl',
            3 => 'testUrl',
        ];
        $expectedMediaUrlCollection = new MediaUrlCollection($expectedMediaUrlGroups);
        $this->mediaUrlCollectionByDocumentConverterMock->outputMediaUrlCollection = $expectedMediaUrlCollection;
        $this->mediaUrlCollectionRandomizerMock->outputMediaUrlCollection = new MediaUrlCollection([]);

        $mediaUrlCollection = $this->memeGeneratorImagesLoadHandler->handle($expectedLocation, $expectedImageCounter);

        $expectedMediaUrlGroups = [];
        self::assertSame($expectedMediaUrlGroups, $mediaUrlCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame($expectedPageDocument, $this->mediaUrlCollectionByDocumentConverterMock->inputDocument);
        self::assertSame($expectedLocation, $this->mediaUrlCollectionByDocumentConverterMock->inputLocation);
        self::assertSame(
            $expectedMediaUrlGroups,
            $this->mediaUrlCollectionRandomizerMock->inputMediaUrlData,
        );
    }
}
