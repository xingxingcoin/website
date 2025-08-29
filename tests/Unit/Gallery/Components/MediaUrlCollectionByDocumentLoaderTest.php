<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components;

use App\Gallery\Components\MediaUrlCollectionByDocumentLoader;
use App\Gallery\GalleryImagesLoadHandler;
use App\Tests\Unit\CustomTestCase;
use App\Tests\Unit\Gallery\Components\Mocks\MediaByMediaIdLoaderMock;
use App\Tests\Unit\Gallery\Components\Mocks\NavigationUrlLoaderMock;
use App\Tests\Unit\Mocks\MediaMock;
use PHPUnit\Framework\Attributes\CoversClass;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Content\Document\Structure\PropertyValue;
use App\Database\Exception\MediaNotFoundException;
use App\Database\Model\NavigationUrl;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use XingXingCoin\Core\Model\Location;

#[CoversClass(MediaUrlCollectionByDocumentLoader::class)]
#[CoversClass(Location::class)]
#[CoversClass(NavigationUrl::class)]
#[CoversClass(SubNavigation::class)]
#[CoversClass(RootNavigation::class)]
final class MediaUrlCollectionByDocumentLoaderTest extends CustomTestCase
{
    private MediaByMediaIdLoaderMock $mediaByMediaIdLoaderMock;
    private NavigationUrlLoaderMock $navigationUrlLoaderMock;
    private MediaUrlCollectionByDocumentLoader $mediaUrlCollectionByDocumentLoader;

    protected function setUp(): void
    {
        $this->mediaByMediaIdLoaderMock = new MediaByMediaIdLoaderMock();
        $this->navigationUrlLoaderMock = new NavigationUrlLoaderMock();
        $this->mediaUrlCollectionByDocumentLoader = new MediaUrlCollectionByDocumentLoader(
            $this->mediaByMediaIdLoaderMock,
            $this->navigationUrlLoaderMock
        );
    }

    public function testLoad_is_valid(): void
    {
        $expectedMediaBlock = [
            'media' => [
                'ids' => [
                    1,
                    2
                ]
            ]
        ];
        $expectedPropertyValue = $this->getMock(PropertyValue::class);
        $expectedPropertyValue->expects(self::once())
            ->method('offsetGet')
            ->with(0)
            ->willReturn($expectedMediaBlock);
        $expectedStructure = $this->getMock(StructureInterface::class);
        $expectedStructure->expects(self::once())
            ->method('getProperty')
            ->with('blocks')
            ->willReturn($expectedPropertyValue);
        $expectedDocument = $this->getMock(BasePageDocument::class);
        $expectedDocument->expects(self::once())
            ->method('getStructure')
            ->willReturn($expectedStructure);
        $expectedLocation = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $expectedLocation->value);
        $expectedMedia->setUrl('testUrl');
        $this->mediaByMediaIdLoaderMock->outputMedia = $expectedMedia;
        $navigationUrl = new NavigationUrl('testUrl');
        $this->navigationUrlLoaderMock->outputNavigationUrl = $navigationUrl;
        $mediaUrlCollection = $this->mediaUrlCollectionByDocumentLoader->load(
            $expectedDocument,
            $expectedLocation,
            new RootNavigation(GalleryImagesLoadHandler::ROOT_NAVIGATION),
            new SubNavigation(GalleryImagesLoadHandler::SUB_NAVIGATION)
        );

        $expectedMediaUrlCollection = new MediaUrlCollection([
            [
                'imageViewerUrl' => 'testUrl?mediaId=1',
                'mediaUrl' => 'testUrl'
            ],
            [
                'imageViewerUrl' => 'testUrl?mediaId=2',
                'mediaUrl' => 'testUrl'
            ]
        ]);
        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame(2, $this->mediaByMediaIdLoaderMock->inputMediaId->value);
        self::assertSame($expectedLocation->value, $this->mediaByMediaIdLoaderMock->inputLocation->value);
        self::assertSame(
            GalleryImagesLoadHandler::ROOT_NAVIGATION,
            $this->navigationUrlLoaderMock->inputRootNavigation->value
        );
        self::assertSame(
            GalleryImagesLoadHandler::SUB_NAVIGATION,
            $this->navigationUrlLoaderMock->inputSubNavigation->value
        );
    }

    public function testLoad_with_empty_media_ids(): void
    {
        $expectedMediaBlock = [
            'media' => [
                'ids' => [
                ]
            ]
        ];
        $expectedPropertyValue = $this->getMock(PropertyValue::class);
        $expectedPropertyValue->expects(self::once())
            ->method('offsetGet')
            ->with(0)
            ->willReturn($expectedMediaBlock);
        $expectedStructure = $this->getMock(StructureInterface::class);
        $expectedStructure->expects(self::once())
            ->method('getProperty')
            ->with('blocks')
            ->willReturn($expectedPropertyValue);
        $expectedDocument = $this->getMock(BasePageDocument::class);
        $expectedDocument->expects(self::once())
            ->method('getStructure')
            ->willReturn($expectedStructure);
        $expectedLocation = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $expectedLocation->value);
        $expectedMedia->setUrl('testUrl');
        $this->mediaByMediaIdLoaderMock->outputMedia = $expectedMedia;
        $navigationUrl = new NavigationUrl('testUrl');
        $this->navigationUrlLoaderMock->outputNavigationUrl = $navigationUrl;
        $mediaUrlCollection = $this->mediaUrlCollectionByDocumentLoader->load(
            $expectedDocument,
            $expectedLocation,
            new RootNavigation(GalleryImagesLoadHandler::ROOT_NAVIGATION),
            new SubNavigation(GalleryImagesLoadHandler::SUB_NAVIGATION)
        );

        $expectedMediaUrlCollection = new MediaUrlCollection([]);
        self::assertEquals($expectedMediaUrlCollection->data, $mediaUrlCollection->data);
        self::assertSame(
            GalleryImagesLoadHandler::ROOT_NAVIGATION,
            $this->navigationUrlLoaderMock->inputRootNavigation->value
        );
        self::assertSame(
            GalleryImagesLoadHandler::SUB_NAVIGATION,
            $this->navigationUrlLoaderMock->inputSubNavigation->value
        );
    }

    public function testLoad_with_ids_equals_null(): void
    {
        $expectedMediaBlock = [
            'media' => []
        ];
        $expectedPropertyValue = $this->getMock(PropertyValue::class);
        $expectedPropertyValue->expects(self::once())
            ->method('offsetGet')
            ->with(0)
            ->willReturn($expectedMediaBlock);
        $expectedStructure = $this->getMock(StructureInterface::class);
        $expectedStructure->expects(self::once())
            ->method('getProperty')
            ->with('blocks')
            ->willReturn($expectedPropertyValue);
        $expectedDocument = $this->getMock(BasePageDocument::class);
        $expectedDocument->expects(self::once())
            ->method('getStructure')
            ->willReturn($expectedStructure);
        $expectedLocation = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $expectedLocation->value);
        $expectedMedia->setUrl('testUrl');
        $this->mediaByMediaIdLoaderMock->outputMedia = $expectedMedia;
        $navigationUrl = new NavigationUrl('testUrl');
        $this->navigationUrlLoaderMock->outputNavigationUrl = $navigationUrl;
        try {
            $this->mediaUrlCollectionByDocumentLoader->load(
                $expectedDocument,
                $expectedLocation,
                new RootNavigation(GalleryImagesLoadHandler::ROOT_NAVIGATION),
                new SubNavigation(GalleryImagesLoadHandler::SUB_NAVIGATION)
            );
            $this->fail('MediaUrlNotLoadedException was expected to be thrown.');
        } catch (MediaUrlNotLoadedException $exception) {
            self::assertSame('Media id not found.', $exception->getMessage());
        }

        self::assertSame(
            GalleryImagesLoadHandler::ROOT_NAVIGATION,
            $this->navigationUrlLoaderMock->inputRootNavigation->value
        );
        self::assertSame(
            GalleryImagesLoadHandler::SUB_NAVIGATION,
            $this->navigationUrlLoaderMock->inputSubNavigation->value
        );
    }

    public function testLoad_with_media_equals_null(): void
    {
        $expectedMediaBlock = [];
        $expectedPropertyValue = $this->getMock(PropertyValue::class);
        $expectedPropertyValue->expects(self::once())
            ->method('offsetGet')
            ->with(0)
            ->willReturn($expectedMediaBlock);
        $expectedStructure = $this->getMock(StructureInterface::class);
        $expectedStructure->expects(self::once())
            ->method('getProperty')
            ->with('blocks')
            ->willReturn($expectedPropertyValue);
        $expectedDocument = $this->getMock(BasePageDocument::class);
        $expectedDocument->expects(self::once())
            ->method('getStructure')
            ->willReturn($expectedStructure);
        $expectedLocation = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $expectedLocation->value);
        $expectedMedia->setUrl('testUrl');
        $this->mediaByMediaIdLoaderMock->outputMedia = $expectedMedia;
        $navigationUrl = new NavigationUrl('testUrl');
        $this->navigationUrlLoaderMock->outputNavigationUrl = $navigationUrl;
        try {
            $this->mediaUrlCollectionByDocumentLoader->load(
                $expectedDocument,
                $expectedLocation,
                new RootNavigation(GalleryImagesLoadHandler::ROOT_NAVIGATION),
                new SubNavigation(GalleryImagesLoadHandler::SUB_NAVIGATION)
            );
            $this->fail('MediaUrlNotLoadedException was expected to be thrown.');
        } catch (MediaUrlNotLoadedException $exception) {
            self::assertSame('Media id not found.', $exception->getMessage());
        }

        self::assertSame(
            GalleryImagesLoadHandler::ROOT_NAVIGATION,
            $this->navigationUrlLoaderMock->inputRootNavigation->value
        );
        self::assertSame(
            GalleryImagesLoadHandler::SUB_NAVIGATION,
            $this->navigationUrlLoaderMock->inputSubNavigation->value
        );
    }

    public function testLoad_with_media_manager_not_found(): void
    {
        $expectedMediaBlock = [
            'media' => [
                'ids' => [
                    1,
                    2
                ]
            ]
        ];
        $expectedPropertyValue = $this->getMock(PropertyValue::class);
        $expectedPropertyValue->expects(self::once())
            ->method('offsetGet')
            ->with(0)
            ->willReturn($expectedMediaBlock);
        $expectedStructure = $this->getMock(StructureInterface::class);
        $expectedStructure->expects(self::once())
            ->method('getProperty')
            ->with('blocks')
            ->willReturn($expectedPropertyValue);
        $expectedDocument = $this->getMock(BasePageDocument::class);
        $expectedDocument->expects(self::once())
            ->method('getStructure')
            ->willReturn($expectedStructure);
        $expectedLocation = new Location('en');
        $expectedMedia = new Media(new MediaMock(), $expectedLocation->value);
        $expectedMedia->setUrl('testUrl');
        $this->mediaByMediaIdLoaderMock->throwMediaNotFoundException = new MediaNotFoundException('test');
        $navigationUrl = new NavigationUrl('testUrl');
        $this->navigationUrlLoaderMock->outputNavigationUrl = $navigationUrl;
        try {
            $this->mediaUrlCollectionByDocumentLoader->load(
                $expectedDocument,
                $expectedLocation,
                new RootNavigation(GalleryImagesLoadHandler::ROOT_NAVIGATION),
                new SubNavigation(GalleryImagesLoadHandler::SUB_NAVIGATION)
            );
            $this->fail('MediaNotFoundException was expected to be thrown.');
        } catch (MediaNotFoundException $exception) {
            self::assertSame('test', $exception->getMessage());
        }

        self::assertSame(
            GalleryImagesLoadHandler::ROOT_NAVIGATION,
            $this->navigationUrlLoaderMock->inputRootNavigation->value
        );
        self::assertSame(
            GalleryImagesLoadHandler::SUB_NAVIGATION,
            $this->navigationUrlLoaderMock->inputSubNavigation->value
        );
        self::assertSame(1, $this->mediaByMediaIdLoaderMock->inputMediaId->value);
        self::assertSame($expectedLocation->value, $this->mediaByMediaIdLoaderMock->inputLocation->value);
    }
}
