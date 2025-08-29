<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components;

use App\Database\Exception\MediaNotFoundException;
use App\Database\Model\NavigationUrl;
use App\Gallery\Components\GalleryMediaCollectionByDocumentLoader;
use App\Gallery\GalleryImagesLoadHandler;
use App\Tests\Unit\CustomTestCase;
use App\Tests\Unit\Gallery\Components\Mocks\MediaByMediaIdLoaderMock;
use App\Tests\Unit\Gallery\Components\Mocks\NavigationUrlLoaderMock;
use App\Tests\Unit\Mocks\MediaMock;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Entity\File;
use Sulu\Bundle\MediaBundle\Entity\FileVersion;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Content\Document\Structure\PropertyValue;
use XingXingCoin\Core\Gallery\Exception\MediaDataNotLoadedException;
use XingXingCoin\Core\Gallery\Model\MediaCollection;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use App\Model\Location;

#[CoversClass(GalleryMediaCollectionByDocumentLoader::class)]
#[CoversClass(Location::class)]
#[CoversClass(NavigationUrl::class)]
#[CoversClass(SubNavigation::class)]
#[CoversClass(RootNavigation::class)]
final class GalleryMediaCollectionByDocumentLoaderTest extends CustomTestCase
{
    private MediaByMediaIdLoaderMock $mediaByMediaIdLoaderMock;
    private NavigationUrlLoaderMock $navigationUrlLoaderMock;
    private GalleryMediaCollectionByDocumentLoader $mediaCollectionByDocumentLoader;

    protected function setUp(): void
    {
        $this->mediaByMediaIdLoaderMock = new MediaByMediaIdLoaderMock();
        $this->navigationUrlLoaderMock = new NavigationUrlLoaderMock();
        $this->mediaCollectionByDocumentLoader = new GalleryMediaCollectionByDocumentLoader(
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
        $expectedFileVersion = new FileVersion();
        $expectedFileVersion->setName('testImage');
        $expectedFileVersion->setVersion(10);
        $mediaMock = new MediaMock();
        $file = new File();
        $file->addFileVersion($expectedFileVersion);
        $file->setVersion(10);
        $fileCollection = new ArrayCollection([$file]);
        $mediaMock->outputFileCollection = $fileCollection;
        $expectedMedia = new Media($mediaMock, $expectedLocation->value, 10);
        $expectedMedia->setUrl('testUrl');
        $this->mediaByMediaIdLoaderMock->outputMedia = $expectedMedia;
        $navigationUrl = new NavigationUrl('testUrl');
        $this->navigationUrlLoaderMock->outputNavigationUrl = $navigationUrl;
        $mediaCollection = $this->mediaCollectionByDocumentLoader->load(
            $expectedDocument,
            $expectedLocation,
            new RootNavigation(GalleryImagesLoadHandler::ROOT_NAVIGATION),
            new SubNavigation(GalleryImagesLoadHandler::SUB_NAVIGATION)
        );

        $expectedMediaCollection = new MediaCollection([
            [
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testUrl?mediaId=1',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testUrl',
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => null,
            ],
            [
                GalleryMediaCollectionByDocumentLoader::IMAGE_VIEWER_URL_KEY => 'testUrl?mediaId=2',
                GalleryMediaCollectionByDocumentLoader::MEDIA_URL_KEY => 'testUrl',
                GalleryMediaCollectionByDocumentLoader::MEDIA_FILE_EXTENSION => null
            ]
        ]);
        self::assertEquals($expectedMediaCollection->data, $mediaCollection->data);
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
        $mediaCollection = $this->mediaCollectionByDocumentLoader->load(
            $expectedDocument,
            $expectedLocation,
            new RootNavigation(GalleryImagesLoadHandler::ROOT_NAVIGATION),
            new SubNavigation(GalleryImagesLoadHandler::SUB_NAVIGATION)
        );

        $expectedMediaCollection = new MediaCollection([]);
        self::assertEquals($expectedMediaCollection->data, $mediaCollection->data);
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
            $this->mediaCollectionByDocumentLoader->load(
                $expectedDocument,
                $expectedLocation,
                new RootNavigation(GalleryImagesLoadHandler::ROOT_NAVIGATION),
                new SubNavigation(GalleryImagesLoadHandler::SUB_NAVIGATION)
            );
            $this->fail('MediaUrlNotLoadedException was expected to be thrown.');
        } catch (MediaDataNotLoadedException $exception) {
            self::assertSame(
                'Media id not found.',
                $exception->getMessage()
            );
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
            $this->mediaCollectionByDocumentLoader->load(
                $expectedDocument,
                $expectedLocation,
                new RootNavigation(GalleryImagesLoadHandler::ROOT_NAVIGATION),
                new SubNavigation(GalleryImagesLoadHandler::SUB_NAVIGATION)
            );
            $this->fail('MediaUrlNotLoadedException was expected to be thrown.');
        } catch (MediaDataNotLoadedException $exception) {
            self::assertSame(
                'Media id not found.',
                $exception->getMessage()
            );
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
            $this->mediaCollectionByDocumentLoader->load(
                $expectedDocument,
                $expectedLocation,
                new RootNavigation(GalleryImagesLoadHandler::ROOT_NAVIGATION),
                new SubNavigation(GalleryImagesLoadHandler::SUB_NAVIGATION)
            );
            $this->fail('MediaNotFoundException was expected to be thrown.');
        } catch (MediaNotFoundException $exception) {
            self::assertSame(
                'test',
                $exception->getMessage()
            );
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
