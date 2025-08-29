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

    public function testLoadMemeGeneratorImages_is_valid(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->galleryImagesFilterLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertEquals('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->galleryImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertEquals([], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImages_with_invalid_image_counter(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->galleryImagesFilterLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertEquals('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(0, $this->galleryImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertEquals([], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImages_with_invalid_image_filter(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 1);
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->galleryImagesFilterLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(400, $jsonResponse->getStatusCode());
        self::assertEquals('{"message":"Bad request."}', $jsonResponse->getContent());
        self::assertEquals([
            'notice' => [
                [
                    'message' => 'Page document could not be loaded.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Page document could not be loaded.',
                    'context' => [
                        'exceptionMessage' => 'Validation failed for value "filter" with error: "Value for "filter" should not be empty."'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImages_with_page_document_not_loaded(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->galleryImagesFilterLoadHandlerMock->throwPageDocumentNotLoadedException = new PageDocumentNotLoadedException(
            'test'
        );

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(400, $jsonResponse->getStatusCode());
        self::assertEquals('{"message":"Bad request."}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->galleryImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertEquals([
            'notice' => [
                [
                    'message' => 'Page document could not be loaded.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Page document could not be loaded.',
                    'context' => [
                        'exceptionMessage' => 'test'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImages_with_media_url_not_loaded(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->galleryImagesFilterLoadHandlerMock->throwMediaDataNotLoadedException = new MediaDataNotLoadedException(
            'test'
        );

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(500, $jsonResponse->getStatusCode());
        self::assertEquals('{"message":"Internal server error."}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->galleryImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertEquals([
            'notice' => [
                [
                    'message' => 'Media urls could not be loaded.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Media urls could not be loaded.',
                    'context' => [
                        'exceptionMessage' => 'test'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImages_with_media_not_found(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->galleryImagesFilterLoadHandlerMock->throwMediaNotFoundException = new MediaNotFoundException('test');

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(500, $jsonResponse->getStatusCode());
        self::assertEquals('{"message":"Internal server error."}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->galleryImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertEquals([
            'notice' => [
                [
                    'message' => 'Media urls could not be loaded.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Media urls could not be loaded.',
                    'context' => [
                        'exceptionMessage' => 'test'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImages_with_empty_locale(): void
    {
        $request = new Request();
        $request->setLocale('');
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(GalleryImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->galleryImagesFilterLoadHandlerMock->throwMediaDataNotLoadedException = new MediaDataNotLoadedException(
            'test'
        );

        $jsonResponse = $this->galleryImagesFilterLoadController->__invoke($request);
        self::assertSame(400, $jsonResponse->getStatusCode());
        self::assertEquals('{"message":"Bad request."}', $jsonResponse->getContent());
        self::assertEquals([
            'notice' => [
                [
                    'message' => 'Page document could not be loaded.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Page document could not be loaded.',
                    'context' => [
                        'exceptionMessage' => 'Validation failed for value "location" with error: "Value for "location" should not be empty."'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }
}
