<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Gallery;

use App\Controller\Api\V1\Gallery\MemeGeneratorImagesInfiniteScrollingLoadController;
use App\Database\Exception\MediaNotFoundException;
use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\Location;
use App\Tests\Unit\Controller\Api\V1\Gallery\Mocks\MemeGeneratorImagesLoadHandlerMock;
use App\Tests\Unit\Mocks\LoggerMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

#[CoversClass(MemeGeneratorImagesInfiniteScrollingLoadController::class)]
#[UsesClass(Location::class)]
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
            $this->loggerMock,
        );
    }

    public function testLoadMemeGeneratorImagesIsValid(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(MemeGeneratorImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->memeGeneratorImagesLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->memeGeneratorImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertSame('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesLoadHandlerMock->inputImageCounter->value);
        self::assertSame([], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImagesWithInvalidImageCounter(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->memeGeneratorImagesLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->memeGeneratorImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertSame('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(0, $this->memeGeneratorImagesLoadHandlerMock->inputImageCounter->value);
        self::assertSame([], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImagesWithPageDocumentNotLoaded(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(MemeGeneratorImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $this->memeGeneratorImagesLoadHandlerMock->throwPageDocumentNotLoadedException = new PageDocumentNotLoadedException(
            'test',
        );

        $jsonResponse = $this->memeGeneratorImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(400, $jsonResponse->getStatusCode());
        self::assertSame('{"message":"Bad request."}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesLoadHandlerMock->inputImageCounter->value);
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
        $request->query->set(MemeGeneratorImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $this->memeGeneratorImagesLoadHandlerMock->throwMediaUrlNotLoadedException = new MediaUrlNotLoadedException(
            'test',
        );

        $jsonResponse = $this->memeGeneratorImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(500, $jsonResponse->getStatusCode());
        self::assertSame('{"message":"Internal server error."}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesLoadHandlerMock->inputImageCounter->value);
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
        $request->query->set(MemeGeneratorImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $this->memeGeneratorImagesLoadHandlerMock->throwMediaNotFoundException = new MediaNotFoundException(
            'test',
        );

        $jsonResponse = $this->memeGeneratorImagesInfiniteScrollingLoadController->__invoke($request);
        self::assertSame(500, $jsonResponse->getStatusCode());
        self::assertSame('{"message":"Internal server error."}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesLoadHandlerMock->inputImageCounter->value);
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
        $request->query->set(MemeGeneratorImagesInfiniteScrollingLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $this->memeGeneratorImagesLoadHandlerMock->throwMediaUrlNotLoadedException = new MediaUrlNotLoadedException(
            'test',
        );

        $jsonResponse = $this->memeGeneratorImagesInfiniteScrollingLoadController->__invoke($request);
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
