<?php

declare(strict_types=1);

namespace App\Tests\Unit\Finance\Components;

use App\Database\Model\DocumentPath;
use App\Database\Model\Location;
use App\Finance\Components\XingNeutralModeGifUrlLoader;
use App\Tests\Unit\CustomTestCase;
use App\Tests\Unit\Database\Mocks\MediaManagerMock;
use App\Tests\Unit\Mocks\DocumentByPathLoaderMock;
use App\Tests\Unit\Mocks\LoggerMock;
use App\Tests\Unit\Mocks\MediaMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Media\Exception\MediaNotFoundException;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Content\Document\Structure\PropertyValue;
use Sulu\Component\DocumentManager\PathBuilder;
use XingXingCoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use XingXingCoin\Core\Finance\Exception\XingGifNotFoundException;

#[CoversClass(XingNeutralModeGifUrlLoader::class)]
#[UsesClass(Location::class)]
#[UsesClass(DocumentPath::class)]
final class XingNeutralModeGifUrlLoaderTest extends CustomTestCase
{
    private MockObject $pathBuilderMock;
    private DocumentByPathLoaderMock $documentByPathLoaderMock;
    private MediaManagerMock $mediaManagerMock;
    private LoggerMock $loggerMock;
    private XingNeutralModeGifUrlLoader $xingNeutralModeGifUrlLoader;

    protected function setUp(): void
    {
        $this->pathBuilderMock = $this->getMock(PathBuilder::class);
        $this->documentByPathLoaderMock = new DocumentByPathLoaderMock();
        $this->mediaManagerMock = new MediaManagerMock();
        $this->loggerMock = new LoggerMock();
        $this->xingNeutralModeGifUrlLoader = new XingNeutralModeGifUrlLoader(
            $this->pathBuilderMock,
            $this->documentByPathLoaderMock,
            $this->mediaManagerMock,
            $this->loggerMock,
        );
    }

    public function testLoadIsValid(): void
    {
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%'])
            ->willReturn($expectedDocumentPath->value);

        $expectedMediaBlock = [
            XingNeutralModeGifUrlLoader::MEDIA_IMAGE_KEY => [
                'id' => 1,
            ],
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
        $newFinanceDataCollection = $this->xingNeutralModeGifUrlLoader->load($financeDataCollection, $expectedLocation);

        self::assertSame([
            'test' => 'test',
            'url' => 'testUrl',
        ], $newFinanceDataCollection->data);
        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame(1, $this->mediaManagerMock->inputId);
        self::assertSame('en', $this->mediaManagerMock->inputLocale);
        self::assertSame([
            'info' => [
                [
                    'message' => 'Start loading xing neutral mode gif url.',
                    'context' => [],
                ],
                [
                    'message' => 'Xing neutral mode gif url is loaded successfully.',
                    'context' => [
                        'mediaId' => 1,
                        'url' => 'testUrl',
                    ],
                ],
            ],
        ], $this->loggerMock->logs);
    }

    public function testLoadWithMediaNotFoundException(): void
    {
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->pathBuilderMock->expects(self::once())
            ->method('build')
            ->with(['%base%', 'website', '%content%'])
            ->willReturn($expectedDocumentPath->value);

        $expectedMediaBlock = [
            XingNeutralModeGifUrlLoader::MEDIA_IMAGE_KEY => [
                'id' => 1,
            ],
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
            $this->xingNeutralModeGifUrlLoader->load(
                $financeDataCollection,
                $expectedLocation,
            );

            $this->fail('XingGifNotFoundException was expected to be thrown.');
        } catch (XingGifNotFoundException $exception) {
            self::assertSame(
                'Xing gif is not found with error: "Media with the ID test was not found".',
                $exception->getMessage(),
            );
        }

        self::assertSame($expectedDocumentPath->value, $this->documentByPathLoaderMock->inputDocumentPath->value);
        self::assertSame(1, $this->mediaManagerMock->inputId);
        self::assertSame('en', $this->mediaManagerMock->inputLocale);
        self::assertSame([
            'info' => [
                [
                    'message' => 'Start loading xing neutral mode gif url.',
                    'context' => [],
                ],
            ],
            'notice' => [
                [
                    'message' => 'Xing neutral mode gif url is not loaded.',
                    'context' => [],
                ],
            ],
            'debug' => [
                [
                    'message' => 'Xing neutral mode gif url is not loaded.',
                    'context' => [
                        'exceptionMessage' => 'Media with the ID test was not found',
                    ],
                ],
            ],
        ], $this->loggerMock->logs);
    }
}
