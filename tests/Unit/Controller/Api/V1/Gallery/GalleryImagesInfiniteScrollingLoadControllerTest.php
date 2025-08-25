<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Gallery;

use App\Controller\Api\V1\Gallery\GalleryImagesInfiniteScrollingLoadController;
use App\Data\Exception\PageDocumentNotLoadedException;
use App\Tests\Unit\Controller\Api\V1\Gallery\Mocks\GalleryImagesLoadHandlerMock;
use App\Tests\Unit\Mocks\LoggerMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Xingxingcoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;
use Xingxingcoin\Core\Model\Location;

#[CoversClass(GalleryImagesInfiniteScrollingLoadController::class)]
#[CoversClass(Location::class)]
final class GalleryImagesInfiniteScrollingLoadControllerTest extends TestCase
{
    private GalleryImagesLoadHandlerMock $galleryImagesLoadHandlerMock;
    private LoggerMock $loggerMock;
    private GalleryImagesInfiniteScrollingLoadController $galleryImagesInfiniteScrollingLoadController;

    protected function setUp(): void
    {
        $this->galleryImagesLoadHandlerMock = new GalleryImagesLoadHandlerMock();
        $this->loggerMock = new LoggerMock();
        $this->galleryImagesInfiniteScrollingLoadController = new GalleryImagesInfiniteScrollingLoadController(
            $this->galleryImagesLoadHandlerMock,
            $this->loggerMock,
        );
    }

    public function testLoadGalleryImages_is_valid(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->galleryImagesLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->galleryImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertEquals('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->galleryImagesLoadHandlerMock->inputImageCounter->value);
        self::assertEquals([], $this->loggerMock->logs);
    }

    public function testLoadGalleryImages_with_invalid_image_counter(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->galleryImagesLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->galleryImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertEquals('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(0, $this->galleryImagesLoadHandlerMock->inputImageCounter->value);
        self::assertEquals([], $this->loggerMock->logs);
    }

    public function testLoadGalleryImages_with_page_document_not_loaded(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $this->galleryImagesLoadHandlerMock->throwPageDocumentNotLoadedException = new PageDocumentNotLoadedException('test');

        $jsonResponse = $this->galleryImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(400, $jsonResponse->getStatusCode());
        self::assertEquals('{"message":"Bad request."}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->galleryImagesLoadHandlerMock->inputImageCounter->value);
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

    public function testLoadGalleryImages_with_media_url_not_loaded(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(GalleryImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $this->galleryImagesLoadHandlerMock->throwMediaUrlNotLoadedException = new MediaUrlNotLoadedException('test');

        $jsonResponse = $this->galleryImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(500, $jsonResponse->getStatusCode());
        self::assertEquals('{"message":"Internal server error."}', $jsonResponse->getContent());
        self::assertSame('en', $this->galleryImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->galleryImagesLoadHandlerMock->inputImageCounter->value);
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

    public function testLoadGalleryImages_with_empty_locale(): void
    {
        $request = new Request();
        $request->setLocale('');
        $request->query->set(GalleryImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $this->galleryImagesLoadHandlerMock->throwMediaUrlNotLoadedException = new MediaUrlNotLoadedException('test');

        $jsonResponse = $this->galleryImagesInfiniteScrollingLoadController->__invoke($request);
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
