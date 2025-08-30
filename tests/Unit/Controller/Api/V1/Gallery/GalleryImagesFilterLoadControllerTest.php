<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Gallery;

use App\Controller\Api\V1\Gallery\GalleryImagesFilterLoadController;
use App\Database\Exception\MediaNotFoundException;
use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\Location;
use App\Tests\Unit\Controller\Api\V1\Gallery\Mocks\GalleryImagesFilterLoadHandlerMock;
use App\Tests\Unit\Mocks\LoggerMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use XingXingCoin\Core\Gallery\Exception\MediaDataNotLoadedException;
use XingXingCoin\Core\Gallery\Model\ImageFilter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

#[CoversClass(GalleryImagesFilterLoadController::class)]
#[UsesClass(Location::class)]
#[UsesClass(ImageFilter::class)]
final class GalleryImagesFilterLoadControllerTest extends TestCase
{
    private GalleryImagesFilterLoadHandlerMock $galleryImagesFilterLoadHandlerMock;
    private LoggerMock $loggerMock;
    private GalleryImagesFilterLoadController $galleryImagesFilterLoadController;

    protected function setUp(): void
    {
        $this->galleryImagesFilterLoadHandlerMock = new GalleryImagesFilterLoadHandlerMock();
        $this->loggerMock = new LoggerMock();
        $this->galleryImagesFilterLoadController = new GalleryImagesFilterLoadController(
            $this->galleryImagesFilterLoadHandlerMock,
            $this->loggerMock,
        );
    }

    public function testLoadMemeGeneratorImagesIsValid(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->galleryImagesFilterLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertSame('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->galleryImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertSame([], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImagesWithInvalidImageCounter(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->galleryImagesFilterLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertSame('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(0, $this->galleryImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertSame([], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImagesWithInvalidImageFilter(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 1);
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->galleryImagesFilterLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(400, $jsonResponse->getStatusCode());
        self::assertSame('{"message":"Bad request."}', $jsonResponse->getContent());
        self::assertSame([
            'notice' => [
                [
                    'message' => 'Page document could not be loaded.',
                    'context' => [],
                ],
            ],
            'debug' => [
                [
                    'message' => 'Page document could not be loaded.',
                    'context' => [
                        'exceptionMessage' => 'Validation failed for value "filter" with error: "Value for "filter" should not be empty."',
                    ],
                ],
            ],
        ], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImagesWithPageDocumentNotLoaded(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->galleryImagesFilterLoadHandlerMock->throwPageDocumentNotLoadedException = new PageDocumentNotLoadedException(
            'test',
        );

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(400, $jsonResponse->getStatusCode());
        self::assertSame('{"message":"Bad request."}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->galleryImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertSame([
            'notice' => [
                [
                    'message' => 'Page document could not be loaded.',
                    'context' => [],
                ],
            ],
            'debug' => [
                [
                    'message' => 'Page document could not be loaded.',
                    'context' => [
                        'exceptionMessage' => 'test',
                    ],
                ],
            ],
        ], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImagesWithMediaUrlNotLoaded(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->galleryImagesFilterLoadHandlerMock->throwMediaDataNotLoadedException = new MediaDataNotLoadedException(
            'test',
        );

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(500, $jsonResponse->getStatusCode());
        self::assertSame('{"message":"Internal server error."}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->galleryImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertSame([
            'notice' => [
                [
                    'message' => 'Media urls could not be loaded.',
                    'context' => [],
                ],
            ],
            'debug' => [
                [
                    'message' => 'Media urls could not be loaded.',
                    'context' => [
                        'exceptionMessage' => 'test',
                    ],
                ],
            ],
        ], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImagesWithMediaNotFound(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->galleryImagesFilterLoadHandlerMock->throwMediaNotFoundException = new MediaNotFoundException('test');

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(500, $jsonResponse->getStatusCode());
        self::assertSame('{"message":"Internal server error."}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->galleryImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertSame([
            'notice' => [
                [
                    'message' => 'Media urls could not be loaded.',
                    'context' => [],
                ],
            ],
            'debug' => [
                [
                    'message' => 'Media urls could not be loaded.',
                    'context' => [
                        'exceptionMessage' => 'test',
                    ],
                ],
            ],
        ], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImagesWithEmptyLocale(): void
    {
        $request = new Request();
        $request->setLocale('');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->galleryImagesFilterLoadHandlerMock->throwMediaDataNotLoadedException = new MediaDataNotLoadedException(
            'test',
        );

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(400, $jsonResponse->getStatusCode());
        self::assertSame('{"message":"Bad request."}', $jsonResponse->getContent());
        self::assertSame([
            'notice' => [
                [
                    'message' => 'Page document could not be loaded.',
                    'context' => [],
                ],
            ],
            'debug' => [
                [
                    'message' => 'Page document could not be loaded.',
                    'context' => [
                        'exceptionMessage' => 'Validation failed for value "location" with error: "Value for "location" should not be empty."',
                    ],
                ],
            ],
        ], $this->loggerMock->logs);
    }
}
