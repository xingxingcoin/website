<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Controller\Api\V1\Gallery;

use App\Controller\Api\V1\Gallery\MemeGeneratorImagesInfiniteScrollingLoadController;
use App\Tests\Acceptance\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Group;

#[Group('Acceptance')]
#[CoversNothing(MemeGeneratorImagesInfiniteScrollingLoadController::class)]
final class MemeGeneratorInfiniteScrollingLoadControllerTest extends AbstractWebTestCase
{
    protected function setUp(): void
    {
        $this->initPhpcr();

        parent::setUp();
    }

    public function testLoadMemeGeneratorImagesForInfiniteScrollingIsValid(): void
    {
        $media = $this->generateMediaTestDataSet();
        $this->generateMemeGeneratorDocumentTestDataSet($media->getId());
        $this->client->request(
            'GET',
            '/api/v1/meme-generator/images?counter=0',
        );

        $response = $this->client->getResponse();

        self::assertSame(\json_encode([
            'urls' => [
                [
                    'imageViewerUrl' => '/meme-generator/new-meme?mediaId=' . $media->getId(),
                    'mediaUrl' => '/media/' . $media->getId() . '/download/test-image.jpg?v=1',
                ],
            ],
        ]), $response->getContent());
        self::assertSame(200, $response->getStatusCode());
    }

    public function testLoadMemeGeneratorImagesForInfiniteScrollingWithBadRequest(): void
    {
        $this->client->request(
            'GET',
            '/api/v1/meme-generator/images?counter=0',
        );

        $response = $this->client->getResponse();

        self::assertSame(\json_encode([
            'message' => 'Bad request.',
        ]), $response->getContent());
        self::assertSame(400, $response->getStatusCode());
    }

    public function testLoadMemeGeneratorImagesForInfiniteScrollingWithInternalServerError(): void
    {
        $mediaId = 0;
        $this->generateMemeGeneratorDocumentTestDataSet($mediaId);
        $this->client->request(
            'GET',
            '/api/v1/meme-generator/images?counter=0',
        );

        $response = $this->client->getResponse();

        self::assertSame(\json_encode([
            'message' => 'Internal server error.',
        ]), $response->getContent());
        self::assertSame(500, $response->getStatusCode());
    }
}
