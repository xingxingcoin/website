<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Controller\Api\V1\Finance;

use App\Controller\Api\V1\Finance\XingFinanceDataLoadController;
use App\Tests\Acceptance\AbstractWebTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Group;

#[Group('Acceptance')]
#[CoversNothing(XingFinanceDataLoadController::class)]
final class XingFinanceDataLoadControllerTest extends AbstractWebTestCase
{
    public function setUp(): void
    {
        $this->initPhpcr();
        parent::setUp();
    }

    public function testLoadXingGeneralData_is_valid(): void
    {
        $this->generateMediaTestDataSet();
        $this->generateGalleryDocumentTestDataSet($this->media->getId());
        $this->generateWebsiteHomepageTestDataSet($this->media->getId());
        $this->client->request(
            'GET',
            '/api/v1/finance/xing'
        );
        $response = $this->client->getResponse();

        self::assertSame(200, $response->getStatusCode());
    }

    public function testLoadXingGeneralData_with_XingGifNotFoundException(): void
    {
        $this->generateMediaTestDataSet();
        $this->generateGalleryDocumentTestDataSet($this->media->getId());
        $this->generateWebsiteHomepageTestDataSet(123456789);
        $this->client->request(
            'GET',
            '/api/v1/finance/xing'
        );
        $response = $this->client->getResponse();

        self::assertSame(500, $response->getStatusCode());
    }
}
