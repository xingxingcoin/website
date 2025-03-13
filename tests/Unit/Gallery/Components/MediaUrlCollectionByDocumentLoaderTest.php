<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components;

use App\Gallery\Components\MediaUrlCollectionByDocumentLoader;
use App\Gallery\Exception\MediaUrlNotLoadedException;
use App\Gallery\Model\Location;
use App\Gallery\Model\MediaUrlCollection;
use App\Tests\Unit\CustomTestCase;
use App\Tests\Unit\Mocks\LoggerMock;
use App\Tests\Unit\Mocks\MediaManagerMock;
use App\Tests\Unit\Mocks\MediaMock;
use PHPUnit\Framework\Attributes\CoversClass;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Media\Exception\MediaNotFoundException;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Content\Document\Structure\PropertyValue;

#[CoversClass(MediaUrlCollectionByDocumentLoader::class)]
#[CoversClass(Location::class)]
final class MediaUrlCollectionByDocumentLoaderTest extends CustomTestCase
{
    private MediaManagerMock $mediaManagerMock;
    private LoggerMock $loggerMock;
    private MediaUrlCollectionByDocumentLoader $mediaUrlCollectionByDocumentLoader;

    protected function setUp(): void
    {
        $this->mediaManagerMock = new MediaManagerMock();
        $this->loggerMock = new LoggerMock();
        $this->mediaUrlCollectionByDocumentLoader = new MediaUrlCollectionByDocumentLoader(
            $this->mediaManagerMock,
            $this->loggerMock
        );
    }

    public function testLoad_is_valid(): void
    {
        $expectedMediaBlock = [
            'media' => [
                'ids' => [
                    1, 2
                ]
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
        $expectedDocument = $this->getMock(BasePageDocument::class);
        $expectedDocument->expects(self::once())
            ->method('getStructure')
            ->willReturn($expectedStructure);
        $expectedLocation = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $expectedLocation->value);
        $expectedMedia->setUrl('testUrl');
        $this->mediaManagerMock->outputMedia = $expectedMedia;
        $mediaUrlCollection = $this->mediaUrlCollectionByDocumentLoader->load($expectedDocument, $expectedLocation);

        $expectedMediaUrlCollection = new MediaUrlCollection([
            'testUrl', 'testUrl'
        ]);
        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame(2, $this->mediaManagerMock->inputId);
        self::assertSame($expectedLocation->value, $this->mediaManagerMock->inputLocale);
        self::assertSame([
            'info' => [
                [
                    'message' => 'Start loading mediaUrls with mediaIds and location.',
                    'context' => []
                ],
                [
                    'message' => 'MediaUrls are successfully loaded.',
                    'context' => []
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoad_with_empty_media_ids(): void
    {
        $expectedMediaBlock = [
            'media' => [
                'ids' => [
                ]
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
        $expectedDocument = $this->getMock(BasePageDocument::class);
        $expectedDocument->expects(self::once())
            ->method('getStructure')
            ->willReturn($expectedStructure);
        $expectedLocation = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $expectedLocation->value);
        $expectedMedia->setUrl('testUrl');
        $this->mediaManagerMock->outputMedia = $expectedMedia;
        $mediaUrlCollection = $this->mediaUrlCollectionByDocumentLoader->load($expectedDocument, $expectedLocation);

        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame([
            'info' => [
                [
                    'message' => 'Start loading mediaUrls with mediaIds and location.',
                    'context' => []
                ],
                [
                    'message' => 'MediaUrls are successfully loaded.',
                    'context' => []
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoad_with_ids_equals_null(): void
    {
        $expectedMediaBlock = [
            'media' => []
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
        $expectedDocument = $this->getMock(BasePageDocument::class);
        $expectedDocument->expects(self::once())
            ->method('getStructure')
            ->willReturn($expectedStructure);
        $expectedLocation = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $expectedLocation->value);
        $expectedMedia->setUrl('testUrl');
        $this->mediaManagerMock->outputMedia = $expectedMedia;
        try {
            $this->mediaUrlCollectionByDocumentLoader->load($expectedDocument, $expectedLocation);
            $this->fail('MediaUrlNotLoadedException was expected to be thrown.');
        } catch (MediaUrlNotLoadedException $exception) {
            self::assertSame('Media with mediaId is not found with error: "Media id not found.".', $exception->getMessage());
        }

        self::assertSame([
            'info' => [
                [
                    'message' => 'Start loading mediaUrls with mediaIds and location.',
                    'context' => []
                ]
            ],
            'notice' => [
                [
                    'message' => 'Error by loading mediaUrls with mediaIds and location.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Error by loading mediaUrls with mediaIds and location.',
                    'context' => [
                        'exceptionMessage' => 'Media id not found.'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoad_with_media_equals_null(): void
    {
        $expectedMediaBlock = [];
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
        $expectedDocument = $this->getMock(BasePageDocument::class);
        $expectedDocument->expects(self::once())
            ->method('getStructure')
            ->willReturn($expectedStructure);
        $expectedLocation = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $expectedLocation->value);
        $expectedMedia->setUrl('testUrl');
        $this->mediaManagerMock->outputMedia = $expectedMedia;
        try {
            $this->mediaUrlCollectionByDocumentLoader->load($expectedDocument, $expectedLocation);
            $this->fail('MediaUrlNotLoadedException was expected to be thrown.');
        } catch (MediaUrlNotLoadedException $exception) {
            self::assertSame('Media with mediaId is not found with error: "Media id not found.".', $exception->getMessage());
        }

        self::assertSame([
            'info' => [
                [
                    'message' => 'Start loading mediaUrls with mediaIds and location.',
                    'context' => []
                ]
            ],
            'notice' => [
                [
                    'message' => 'Error by loading mediaUrls with mediaIds and location.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Error by loading mediaUrls with mediaIds and location.',
                    'context' => [
                        'exceptionMessage' => 'Media id not found.'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoad_with_media_manager_not_found(): void
    {
        $expectedMediaBlock = [
            'media' => [
                'ids' => [
                    1, 2
                ]
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
        $expectedDocument = $this->getMock(BasePageDocument::class);
        $expectedDocument->expects(self::once())
            ->method('getStructure')
            ->willReturn($expectedStructure);
        $expectedLocation = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $expectedLocation->value);
        $expectedMedia->setUrl('testUrl');
        $this->mediaManagerMock->throwMediaNotFoundException = new MediaNotFoundException('test');
        try {
            $this->mediaUrlCollectionByDocumentLoader->load($expectedDocument, $expectedLocation);
            $this->fail('MediaUrlNotLoadedException was expected to be thrown.');
        } catch (MediaUrlNotLoadedException $exception) {
            self::assertSame('Media with mediaId is not found with error: "Media with the ID test was not found".', $exception->getMessage());
        }

        self::assertSame(1, $this->mediaManagerMock->inputId);
        self::assertSame($expectedLocation->value, $this->mediaManagerMock->inputLocale);
        self::assertSame([
            'info' => [
                [
                    'message' => 'Start loading mediaUrls with mediaIds and location.',
                    'context' => []
                ]
            ],
            'notice' => [
                [
                    'message' => 'Error by loading mediaUrls with mediaIds and location.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Error by loading mediaUrls with mediaIds and location.',
                    'context' => [
                        'exceptionMessage' => 'Media with the ID test was not found'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }
}
