<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database;

use App\Database\DefaultMediaByMediaIdLoader;
use App\Database\Model\Location;
use App\Database\Model\MediaId;
use App\Tests\Unit\Database\Mocks\MediaManagerMock;
use App\Tests\Unit\Mocks\LoggerMock;
use App\Tests\Unit\Mocks\MediaMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Media\Exception\MediaNotFoundException;

#[CoversClass(DefaultMediaByMediaIdLoader::class)]
#[UsesClass(Location::class)]
final class DefaultMediaByMediaIdLoaderTest extends TestCase
{
    private MediaManagerMock $mediaManagerMock;
    private LoggerMock $loggerMock;
    private DefaultMediaByMediaIdLoader $defaultMediaByMediaIdLoader;

    protected function setUp(): void
    {
        $this->mediaManagerMock = new MediaManagerMock();
        $this->loggerMock = new LoggerMock();
        $this->defaultMediaByMediaIdLoader = new DefaultMediaByMediaIdLoader(
            $this->mediaManagerMock,
            $this->loggerMock,
        );
    }

    public function testLoadIsValid(): void
    {
        $mediaId = new MediaId(1);
        $location = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $location->value);
        $this->mediaManagerMock->outputMedia = $expectedMedia;

        $media = $this->defaultMediaByMediaIdLoader->load($mediaId, $location);

        self::assertSame($expectedMedia, $media);
        self::assertSame($mediaId->value, $this->mediaManagerMock->inputId);
        self::assertSame($location->value, $this->mediaManagerMock->inputLocale);
        self::assertSame([
            'info' => [
                [
                    'message' => 'Start loading media with mediaId and location.',
                    'context' => [],
                ],
                [
                    'message' => 'Media by mediaId and location is successfully loaded.',
                    'context' => [],
                ],
            ],
            'debug' => [
                [
                    'message' => 'Start loading media with mediaId and location.',
                    'context' => [
                        'mediaId' => 1,
                        'location' => 'en',
                    ],
                ],
            ],
        ], $this->loggerMock->logs);
    }

    public function testLoadWithMediaNotFoundException(): void
    {
        $mediaId = new MediaId(1);
        $location = new Location('en');
        $this->mediaManagerMock->throwMediaNotFoundException = new MediaNotFoundException('test');

        try {
            $this->defaultMediaByMediaIdLoader->load($mediaId, $location);
            $this->fail('MediaNotFoundException was expected to be thrown.');
        } catch (\App\Database\Exception\MediaNotFoundException $exception) {
            self::assertSame(
                'Validation failed for value "1" with error: "Media with id "1" could not be loaded."',
                $exception->getMessage(),
            );
        }

        self::assertSame([
            'info' => [
                [
                    'message' => 'Start loading media with mediaId and location.',
                    'context' => [],
                ],
            ],
            'debug' => [
                [
                    'message' => 'Start loading media with mediaId and location.',
                    'context' => [
                        'mediaId' => 1,
                        'location' => 'en',
                    ],
                ],
                [
                    'message' => 'Error by loading media with mediaId and location.',
                    'context' => [
                        'exceptionMessage' => 'Media with the ID test was not found',
                    ],
                ],
            ],
            'notice' => [
                [
                    'message' => 'Error by loading media with mediaId and location.',
                    'context' => [],
                ],
            ],
        ], $this->loggerMock->logs);
    }
}
