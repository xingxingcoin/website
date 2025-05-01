<?php

declare(strict_types=1);

namespace App\Tests\Unit\Finance\Components;

use App\Finance\Components\XingHappyModeGifUrlLoader;
use App\Finance\Exception\XingGifNotFoundException;
use App\Finance\Model\FinanceDataCollection;
use App\Model\Location;
use App\Tests\Unit\CustomTestCase;
use App\Tests\Unit\Mocks\DocumentByPathLoaderMock;
use App\Tests\Unit\Mocks\LoggerMock;
use App\Tests\Unit\Mocks\MediaManagerMock;
use App\Tests\Unit\Mocks\MediaMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Media\Exception\MediaNotFoundException;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Content\Document\Structure\PropertyValue;
use Sulu\Component\DocumentManager\PathBuilder;

#[CoversClass(XingHappyModeGifUrlLoader::class)]
#[CoversClass(Location::class)]
final class XingHappyModeGifUrlLoaderTest extends CustomTestCase
{
    private MockObject $pathBuilderMock;
    private DocumentByPathLoaderMock $documentByPathLoaderMock;
    private MediaManagerMock $mediaManagerMock;
    private LoggerMock $loggerMock;
    private XingHappyModeGifUrlLoader $xingHappyModeGifUrlLoader;

    protected function setUp(): void
    {
        $this->pathBuilderMock = $this->getMock(PathBuilder::class);
        $this->documentByPathLoaderMock = new DocumentByPathLoaderMock();
        $this->mediaManagerMock = new MediaManagerMock();
        $this->loggerMock = new LoggerMock();
        $this->xingHappyModeGifUrlLoader = new XingHappyModeGifUrlLoader(
            $this->pathBuilderMock,
            $this->documentByPathLoaderMock,
            $this->mediaManagerMock,
            $this->loggerMock
        );
    }

    public function testLoad_is_valid(): void
    {
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%'])
            ->willReturn($expectedPath);

        $expectedMediaBlock = [
            XingHappyModeGifUrlLoader::MEDIA_IMAGE_KEY => [
                'id' => 1
            ]
        ];
        $expectedPropertyValue = $this->getMock(PropertyValue::class);
        $expectedPropertyValue->expects(self::once())
            ->method('offsetGet')
            ->with(0)
            ->willReturn($expectedMediaBlock);
        $expectedStructure = $this->getMock(StructureInterface::class);
        $expectedStructure->expects(self::once())
            ->method('getProperty')
            ->with('blocks')
            ->willReturn($expectedPropertyValue);
        $expectedPageDocument = $this->getMock(BasePageDocument::class);
        $expectedPageDocument->expects(self::once())
            ->method('getStructure')
            ->willReturn($expectedStructure);
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedLocation = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $expectedLocation->value);
        $expectedMedia->setFormats(['sulu-400x400' => 'testUrl']);
        $this->mediaManagerMock->outputMedia = $expectedMedia;

        $financeDataCollection = new FinanceDataCollection(['test' => 'test']);
        $newFinanceDataCollection = $this->xingHappyModeGifUrlLoader->load($financeDataCollection, $expectedLocation);

        self::assertEquals([
            'test' => 'test',
            'url' => 'testUrl'
        ], $newFinanceDataCollection->data);
        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertEquals(1, $this->mediaManagerMock->inputId);
        self::assertEquals('en', $this->mediaManagerMock->inputLocale);
        self::assertEquals([
            'info' => [
                [
                    'message' => 'Start loading xing happy mode gif url.',
                    'context' => [],
                ],
                [
                    'message' => 'Xing happy mode gif url is loaded successfully.',
                    'context' => [
                        'mediaId' => 1,
                        'url' => 'testUrl'
                    ],
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoad_with_MediaNotFoundException(): void
    {
        $expectedPath = 'testPath';
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%'])
            ->willReturn($expectedPath);

        $expectedMediaBlock = [
            XingHappyModeGifUrlLoader::MEDIA_IMAGE_KEY => [
                'id' => 1
            ]
        ];
        $expectedPropertyValue = $this->getMock(PropertyValue::class);
        $expectedPropertyValue->expects(self::once())
            ->method('offsetGet')
            ->with(0)
            ->willReturn($expectedMediaBlock);
        $expectedStructure = $this->getMock(StructureInterface::class);
        $expectedStructure->expects(self::once())
            ->method('getProperty')
            ->with('blocks')
            ->willReturn($expectedPropertyValue);
        $expectedPageDocument = $this->getMock(BasePageDocument::class);
        $expectedPageDocument->expects(self::once())
            ->method('getStructure')
            ->willReturn($expectedStructure);
        $this->documentByPathLoaderMock->outputBasePageDocument = $expectedPageDocument;
        $expectedLocation = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $expectedLocation->value);
        $expectedMedia->setFormats(['sulu-400x400' => 'testUrl']);
        $this->mediaManagerMock->outputMedia = $expectedMedia;
        $this->mediaManagerMock->throwMediaNotFoundException = new MediaNotFoundException('test');

        $financeDataCollection = new FinanceDataCollection([]);
        try {
            $this->xingHappyModeGifUrlLoader->load(
                $financeDataCollection,
                $expectedLocation
            );

            $this->fail('XingGifNotFoundException was expected to be thrown.');
        } catch (XingGifNotFoundException $exception) {
            self::assertSame('Xing gif is not found with error: "Media with the ID test was not found".', $exception->getMessage());
        }

        self::assertSame($expectedPath, $this->documentByPathLoaderMock->inputPath);
        self::assertEquals(1, $this->mediaManagerMock->inputId);
        self::assertEquals('en', $this->mediaManagerMock->inputLocale);
        self::assertEquals([
            'info' => [
                [
                    'message' => 'Start loading xing happy mode gif url.',
                    'context' => [],
                ]
            ],
            'notice' => [
                [
                    'message' => 'Xing happy mode gif url is not loaded.',
                    'context' => [],
                ]
            ],
            'debug' => [
                [
                    'message' => 'Xing happy mode gif url is not loaded.',
                    'context' => [
                        'exceptionMessage' => 'Media with the ID test was not found'
                    ],
                ]
            ]
        ], $this->loggerMock->logs);
    }
}
