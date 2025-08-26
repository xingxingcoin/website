<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database;

use App\Database\MediaByMediaIdLoader;
use App\Tests\Unit\Database\Mocks\MediaManagerMock;
use App\Tests\Unit\Mocks\LoggerMock;
use App\Tests\Unit\Mocks\MediaMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Media\Exception\MediaNotFoundException;
use XingXingCoin\Core\Database\Model\MediaId;
use XingXingCoin\Core\Model\Location;

#[CoversClass(MediaByMediaIdLoader::class)]
#[CoversClass(Location::class)]
final class MediaByMediaIdLoaderTest extends TestCase
{
    private MediaManagerMock $mediaManagerMock;
    private LoggerMock $loggerMock;
    private MediaByMediaIdLoader $mediaByMediaIdLoader;

    protected function setUp(): void
    {
        $this->mediaManagerMock = new MediaManagerMock();
        $this->loggerMock = new LoggerMock();
        $this->mediaByMediaIdLoader = new MediaByMediaIdLoader(
            $this->mediaManagerMock,
            $this->loggerMock
        );
    }

    public function testLoad_is_valid(): void
    {
        $mediaId = new MediaId(1);
        $location = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $location->value);
        $this->mediaManagerMock->outputMedia = $expectedMedia;

        $media = $this->mediaByMediaIdLoader->load($mediaId, $location);

        self::assertEquals($expectedMedia, $media);
        self::assertSame($mediaId->value, $this->mediaManagerMock->inputId);
        self::assertSame($location->value, $this->mediaManagerMock->inputLocale);
        self::assertEquals([
            'info' => [
                [
                    'message' => 'Start loading media with mediaId and location.',
                    'context' => []
                ],
                [
                    'message' => 'Media by mediaId and location is successfully loaded.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Start loading media with mediaId and location.',
                    'context' => [
                        'mediaId' => 1,
                        'location' => 'en'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoad_with_MediaNotFoundException(): void
    {
        $mediaId = new MediaId(1);
        $location = new Location('en');
        $this->mediaManagerMock->throwMediaNotFoundException = new MediaNotFoundException('test');

        try {
            $this->mediaByMediaIdLoader->load($mediaId, $location);
            $this->fail('MediaNotFoundException was expected to be thrown.');
        } catch (\XingXingCoin\Core\Database\Exception\MediaNotFoundException $exception) {
            self::assertSame(
                'Validation failed for value "1" with error: "Media with id "1" could not be loaded."',
                $exception->getMessage()
            );
        }

        self::assertEquals([
            'info' => [
                [
                    'message' => 'Start loading media with mediaId and location.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Start loading media with mediaId and location.',
                    'context' => [
                        'mediaId' => 1,
                        'location' => 'en'
                    ]
                ],
                [
                    'message' => 'Error by loading media with mediaId and location.',
                    'context' => [
                        'exceptionMessage' => 'Media with the ID test was not found'
                    ]
                ]
            ],
            'notice' => [
                [
                    'message' => 'Error by loading media with mediaId and location.',
                    'context' => []
                ]
            ]
        ], $this->loggerMock->logs);
    }
}
