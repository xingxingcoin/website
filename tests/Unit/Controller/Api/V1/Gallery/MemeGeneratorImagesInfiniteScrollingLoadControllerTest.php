<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Gallery;

use App\Controller\Api\V1\Gallery\MemeGeneratorImagesInfiniteScrollingLoadController;
use App\Data\Exception\PageDocumentNotLoadedException;
use App\Tests\Unit\Controller\Api\V1\Gallery\Mocks\MemeGeneratorImagesLoadHandlerMock;
use App\Tests\Unit\Mocks\LoggerMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Xingxingcoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;
use Xingxingcoin\Core\Model\Location;

#[CoversClass(MemeGeneratorImagesInfiniteScrollingLoadController::class)]
#[CoversClass(Location::class)]
final class MemeGeneratorImagesInfiniteScrollingLoadControllerTest extends TestCase
{
    private MemeGeneratorImagesLoadHandlerMock $memeGeneratorImagesLoadHandlerMock;
    private LoggerMock $loggerMock;
    private MemeGeneratorImagesInfiniteScrollingLoadController $memeGeneratorImagesInfiniteScrollingLoadController;

    protected function setUp(): void
    {
        $this->memeGeneratorImagesLoadHandlerMock = new MemeGeneratorImagesLoadHandlerMock();
        $this->loggerMock = new LoggerMock();
        $this->memeGeneratorImagesInfiniteScrollingLoadController = new MemeGeneratorImagesInfiniteScrollingLoadController(
            $this->memeGeneratorImagesLoadHandlerMock,
            $this->loggerMock
        );
    }

    public function testLoadMemeGeneratorImages_is_valid(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(MemeGeneratorImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->memeGeneratorImagesLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->memeGeneratorImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertEquals('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesLoadHandlerMock->inputImageCounter->value);
        self::assertEquals([], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImages_with_invalid_image_counter(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->memeGeneratorImagesLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->memeGeneratorImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertEquals('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(0, $this->memeGeneratorImagesLoadHandlerMock->inputImageCounter->value);
        self::assertEquals([], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImages_with_page_document_not_loaded(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(MemeGeneratorImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $this->memeGeneratorImagesLoadHandlerMock->throwPageDocumentNotLoadedException = new PageDocumentNotLoadedException(
            'test'
        );

        $jsonResponse = $this->memeGeneratorImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(400, $jsonResponse->getStatusCode());
        self::assertEquals('{"message":"Bad request."}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesLoadHandlerMock->inputImageCounter->value);
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
        $request->query->set(MemeGeneratorImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $this->memeGeneratorImagesLoadHandlerMock->throwMediaUrlNotLoadedException = new MediaUrlNotLoadedException(
            'test'
        );

        $jsonResponse = $this->memeGeneratorImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(500, $jsonResponse->getStatusCode());
        self::assertEquals('{"message":"Internal server error."}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesLoadHandlerMock->inputImageCounter->value);
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
        $request->query->set(MemeGeneratorImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $this->memeGeneratorImagesLoadHandlerMock->throwMediaUrlNotLoadedException = new MediaUrlNotLoadedException(
            'test'
        );

        $jsonResponse = $this->memeGeneratorImagesInfiniteScrollingLoadController->__invoke($request);
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
