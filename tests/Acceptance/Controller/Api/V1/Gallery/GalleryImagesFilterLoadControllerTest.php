<?php

declare(strict_types=1);

namespace Acceptance\Controller\Api\V1\Gallery;

use App\Tests\Acceptance\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Group;


#[Group('Acceptance')]
#[CoversNothing(GalleryImagesFilterLoadControllerTest::class)]
final class GalleryImagesFilterLoadControllerTest extends AbstractWebTestCase
{
    public function setUp(): void
    {
        $this->initPhpcr();

        parent::setUp();
    }

    public function testLoadGalleryImagesByFilterForInfiniteScrolling_is_valid(): void
    {
        $this->generateMediaTestDataSet();
        $this->generateGalleryDocumentTestDataSet($this->media->getId());
        $this->client->request(
            'GET',
            '/api/v1/gallery/images/filter?counter=0&filter=image'
        );

        $response = $this->client->getResponse();

        self::assertEquals(json_encode([
            'urls' => [
                [
                    'imageViewerUrl' => '/xing-xing-on-camera/image-viewer?mediaId=' . $this->media->getId(),
                    'mediaUrl' => '/media/' . $this->media->getId() . '/download/test-image.jpg?v=1'
                ]
            ]
        ]), $response->getContent());
        self::assertSame(200, $response->getStatusCode());
    }

    public function testLoadGalleryImagesByFilterForInfiniteScrolling_with_bad_request(): void
    {
        $this->client->request(
            'GET',
            '/api/v1/gallery/images?counter=0&filter=image'
        );

        $response = $this->client->getResponse();

        self::assertEquals(json_encode([
            'message' => 'Bad request.'
        ]), $response->getContent());
        self::assertSame(400, $response->getStatusCode());
    }

    public function testLoadGalleryImagesByFilterForInfiniteScrolling_with_internal_server_error(): void
    {
        $mediaId = 0;
        $this->generateGalleryDocumentTestDataSet($mediaId);
        $this->client->request(
            'GET',
            '/api/v1/gallery/images?counter=0&filter=image'
        );

        $response = $this->client->getResponse();

        self::assertEquals(json_encode([
            'message' => 'Internal server error.'
        ]), $response->getContent());
        self::assertSame(500, $response->getStatusCode());
    }
}
