<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Controller\Api\V1\Gallery;

use App\Controller\Api\V1\Gallery\MemeGeneratorImagesFilterLoadController;
use App\Tests\Acceptance\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Group;

#[Group('Acceptance')]
#[CoversNothing(MemeGeneratorImagesFilterLoadController::class)]
final class MemeGeneratorImagesFilterLoadControllerTest extends AbstractWebTestCase
{
    protected function setUp(): void
    {
        $this->initPhpcr();

        parent::setUp();
    }

    public function testLoadMemeGeneratorImagesByFilterForInfiniteScrollingIsValid(): void
    {
        $this->generateMediaTestDataSet();
        $this->generateMemeGeneratorDocumentTestDataSet($this->media->getId());
        $this->client->request(
            'GET',
            '/api/v1/meme-generator/images/filter?counter=0&filter=meme_image',
        );

        $response = $this->client->getResponse();

        self::assertSame(\json_encode([
            'urls' => [
                [
                    'imageViewerUrl' => '/meme-generator/new-meme?mediaId=' . $this->media->getId(),
                    'mediaUrl' => '/media/' . $this->media->getId() . '/download/test-image.jpg?v=1',
                ],
            ],
        ]), $response->getContent());
        self::assertSame(200, $response->getStatusCode());
    }

    public function testLoadMemeGeneratorImagesByFilterForInfiniteScrollingWithBadRequest(): void
    {
        $this->client->request(
            'GET',
            '/api/v1/meme-generator/images/filter?counter=0&filter=meme_image',
        );

        $response = $this->client->getResponse();

        self::assertSame(\json_encode([
            'message' => 'Bad request.',
        ]), $response->getContent());
        self::assertSame(400, $response->getStatusCode());
    }

    public function testLoadMemeGeneratorImagesByFilterForInfiniteScrollingWithInternalServerError(): void
    {
        $mediaId = 0;
        $this->generateMemeGeneratorDocumentTestDataSet($mediaId);
        $this->client->request(
            'GET',
            '/api/v1/meme-generator/images/filter?counter=0&filter=meme_image',
        );

        $response = $this->client->getResponse();

        self::assertSame(\json_encode([
            'message' => 'Internal server error.',
        ]), $response->getContent());
        self::assertSame(500, $response->getStatusCode());
    }
}
