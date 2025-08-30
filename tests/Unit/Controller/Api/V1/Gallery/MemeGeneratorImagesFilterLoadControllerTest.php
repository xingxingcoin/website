<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Gallery;

use App\Controller\Api\V1\Gallery\MemeGeneratorImagesFilterLoadController;
use App\Database\Exception\MediaNotFoundException;
use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\Location;
use App\Tests\Unit\Controller\Api\V1\Gallery\Mocks\MemeGeneratorImagesFilterLoadHandlerMock;
use App\Tests\Unit\Mocks\LoggerMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use XingXingCoin\Core\Gallery\Exception\MediaDataNotLoadedException;
use XingXingCoin\Core\Gallery\Model\ImageFilter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

#[CoversClass(MemeGeneratorImagesFilterLoadController::class)]
#[UsesClass(Location::class)]
#[UsesClass(ImageFilter::class)]
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
            $this->loggerMock,
        );
    }

    public function testLoadMemeGeneratorImagesIsValid(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->memeGeneratorImagesFilterLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertSame('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertSame([], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImagesWithInvalidImageCounter(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->memeGeneratorImagesFilterLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
        self::assertSame(200, $jsonResponse->getStatusCode());
        self::assertSame('{"urls":[]}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(0, $this->memeGeneratorImagesFilterLoadHandlerMock->inputImageCounter->value);
        self::assertSame([], $this->loggerMock->logs);
    }

    public function testLoadMemeGeneratorImagesWithInvalidImageFilter(): void
    {
        $request = new Request();
        $request->setLocale('en');
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 1);
        $mediaUrlCollection = new MediaUrlCollection([]);
        $this->memeGeneratorImagesFilterLoadHandlerMock->outputMediaUrlCollection = $mediaUrlCollection;

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
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
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->memeGeneratorImagesFilterLoadHandlerMock->throwPageDocumentNotLoadedException = new PageDocumentNotLoadedException(
            'test',
        );

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
        self::assertSame(400, $jsonResponse->getStatusCode());
        self::assertSame('{"message":"Bad request."}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesFilterLoadHandlerMock->inputImageCounter->value);
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
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->memeGeneratorImagesFilterLoadHandlerMock->throwMediaDataNotLoadedException = new MediaDataNotLoadedException(
            'test',
        );

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
        self::assertSame(500, $jsonResponse->getStatusCode());
        self::assertSame('{"message":"Internal server error."}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesFilterLoadHandlerMock->inputImageCounter->value);
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
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->memeGeneratorImagesFilterLoadHandlerMock->throwMediaNotFoundException = new MediaNotFoundException(
            'test',
        );

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
        self::assertSame(500, $jsonResponse->getStatusCode());
        self::assertSame('{"message":"Internal server error."}', $jsonResponse->getContent());
        self::assertSame('en', $this->memeGeneratorImagesFilterLoadHandlerMock->inputLocation->value);
        self::assertSame(2, $this->memeGeneratorImagesFilterLoadHandlerMock->inputImageCounter->value);
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
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_COUNTER_KEY, 2);
        $request->query->set(MemeGeneratorImagesFilterLoadController::REQUEST_IMAGE_FILTER_KEY, 'image');
        $this->memeGeneratorImagesFilterLoadHandlerMock->throwMediaDataNotLoadedException = new MediaDataNotLoadedException(
            'test',
        );

        $jsonResponse = $this->memeGeneratorImagesFilterLoadController->__invoke($request);
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
