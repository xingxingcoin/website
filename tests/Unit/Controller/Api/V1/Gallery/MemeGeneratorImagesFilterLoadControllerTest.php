<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Gallery;

use App\Controller\Api\V1\Gallery\MemeGeneratorImagesFilterLoadController;
use App\Tests\Unit\Controller\Api\V1\Gallery\Mocks\MemeGeneratorImagesFilterLoadHandlerMock;
use App\Tests\Unit\Mocks\LoggerMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Xingxingcoin\Core\Database\Exception\PageDocumentNotLoadedException;
use Xingxingcoin\Core\Gallery\Exception\MediaDataNotLoadedException;
use Xingxingcoin\Core\Gallery\Model\ImageFilter;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;
use Xingxingcoin\Core\Model\Location;

#[CoversClass(MemeGeneratorImagesFilterLoadController::class)]
#[CoversClass(Location::class)]
#[CoversClass(ImageFilter::class)]
final class MemeGeneratorImagesFilterLoadControllerTest extends TestCase
{
    private MemeGeneratorImagesFilterLoadHandlerMock $memeGeneratorImagesFilterLoadHandlerMock;
    private LoggerMock $loggerMock;
    private MemeGeneratorImagesFilterLoadController $memeGeneratorImagesFilterLoadController;

    protected function setUp(): void
    {
        $this->memeGeneratorImagesFilterLoadHandlerMock = new MemeGeneratorImagesFilterLoadHandlerMock();
        $this->loggerMock = new LoggerMock();
        $this->memeGeneratorImagesFilterLoadController = new MemeGeneratorImagesFilterLoadController(
            $this->memeGeneratorImagesFilterLoadHandlerMock,
            $this->loggerMock
        );
    }

    public function testLoadMemeGeneratorImages_is_valid(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->memeGeneratorImagesFilterLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertEquals('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertEquals([], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImages_with_invalid_image_counter(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->memeGeneratorImagesFilterLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertEquals('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(0, $this->memeGeneratorImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertEquals([], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImages_with_invalid_image_filter(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 1);
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->memeGeneratorImagesFilterLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
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
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->memeGeneratorImagesFilterLoadHandlerMock->throwPageDocumentNotLoadedException = new PageDocumentNotLoadedException(
            'test'
        );

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
        self::assertSame(400, $jsonResponse->getStatusCode());
        self::assertEquals('{"message":"Bad request."}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesFilterLoadHandlerMock->inputImageCounter->value);
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
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->memeGeneratorImagesFilterLoadHandlerMock->throwMediaDataNotLoadedException = new MediaDataNotLoadedException(
            'test'
        );

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
        self::assertSame(500, $jsonResponse->getStatusCode());
        self::assertEquals('{"message":"Internal server error."}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesFilterLoadHandlerMock->inputImageCounter->value);
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
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->memeGeneratorImagesFilterLoadHandlerMock->throwMediaDataNotLoadedException = new MediaDataNotLoadedException(
            'test'
        );

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
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
