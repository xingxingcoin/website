<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Controller\Api\V1\Gallery;

use App\Controller\Api\V1\Gallery\GalleryImagesInfiniteScrollingLoadController;
use App\Tests\Acceptance\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Group;

#[Group('Acceptance')]
#[CoversNothing(GalleryImagesInfiniteScrollingLoadController::class)]
final class GalleryImagesInfiniteScrollingLoadControllerTest extends AbstractWebTestCase
{
    protected function setUp(): void
    {
        $this->initPhpcr();

        parent::setUp();
    }

    public function testLoadGalleryImagesForInfiniteScrollingIsValid(): void
    {
        $this->generateMediaTestDataSet();
        $this->generateGalleryDocumentTestDataSet($this->media->getId());
        $this->client->request(
            'GET',
            '/api/v1/gallery/images?counter=0',
        );

        $response = $this->client->getResponse();

        self::assertSame(\json_encode([
            'urls' => [
                [
                    'imageViewerUrl' => '/xing-xing-on-camera/image-viewer?mediaId=' . $this->media->getId(),
                    'mediaUrl' => '/media/' . $this->media->getId() . '/download/test-image.jpg?v=1',
                ],
            ],
        ]), $response->getContent());
        self::assertSame(200, $response->getStatusCode());
    }

    public function testLoadGalleryImagesForInfiniteScrollingWithBadRequest(): void
    {
        $this->client->request(
            'GET',
            '/api/v1/gallery/images?counter=0',
        );

        $response = $this->client->getResponse();

        self::assertSame(\json_encode([
            'message' => 'Bad request.',
        ]), $response->getContent());
        self::assertSame(400, $response->getStatusCode());
    }

    public function testLoadGalleryImagesForInfiniteScrollingWithInternalServerError(): void
    {
        $mediaId = 0;
        $this->generateGalleryDocumentTestDataSet($mediaId);
        $this->client->request(
            'GET',
            '/api/v1/gallery/images?counter=0',
        );

        $response = $this->client->getResponse();

        self::assertSame(\json_encode([
            'message' => 'Internal server error.',
        ]), $response->getContent());
        self::assertSame(500, $response->getStatusCode());
    }
}
