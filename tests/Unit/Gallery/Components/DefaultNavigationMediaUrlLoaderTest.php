<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components;

use App\Gallery\Components\DefaultNavigationMediaUrlLoader;
use App\Tests\Unit\Mocks\NavigationMapperMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Xingxingcoin\Core\Gallery\Model\MediaNavigationUrl;
use Xingxingcoin\Core\Gallery\Model\RootNavigation;
use Xingxingcoin\Core\Gallery\Model\SubNavigation;
use Xingxingcoin\Core\Model\Location;
use Xingxingcoin\JsonValidator\Validation\Exception\EmptyStringException;

#[CoversClass(DefaultNavigationMediaUrlLoader::class)]
#[CoversClass(MediaNavigationUrl::class)]
#[CoversClass(RootNavigation::class)]
#[CoversClass(SubNavigation::class)]
#[CoversClass(Location::class)]
final class DefaultNavigationMediaUrlLoaderTest extends TestCase
{
    private NavigationMapperMock $navigationMapperMock;
    private DefaultNavigationMediaUrlLoader $defaultNavigationMediaUrlLoader;

    protected function setUp(): void
    {
        $this->navigationMapperMock = new NavigationMapperMock();
        $this->defaultNavigationMediaUrlLoader = new DefaultNavigationMediaUrlLoader(
            $this->navigationMapperMock
        );
    }

    public function testLoad_is_valid(): void
    {
        $rootNavigation = new RootNavigation('testTemplate');
        $subNavigation = new SubNavigation('testTemplate');
        $location = new Location('en');
        $expectedSubNavigation = [
            [
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_TEMPLATE_KEY => 'testTemplate2',
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_UUID_KEY => 'testUuid2'
            ],
            [
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_TEMPLATE_KEY => 'testTemplate',
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_URL_KEY => 'testUrl'
            ]
        ];
        $this->navigationMapperMock->outputNavigationSubNavigation = $expectedSubNavigation;
        $expectedRootNavigation = [
            [
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_TEMPLATE_KEY => 'testTemplate2',
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_UUID_KEY => 'testUuid2'
            ],
            [
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_TEMPLATE_KEY => 'testTemplate',
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_UUID_KEY => 'testUuid'
            ]
        ];
        $this->navigationMapperMock->outputNavigationRootRootNavigation = $expectedRootNavigation;

        $mediaNavigationUrl = $this->defaultNavigationMediaUrlLoader->load($rootNavigation, $subNavigation, $location);

        self::assertSame('testUrl', $mediaNavigationUrl->value);
        self::assertSame('testUuid', $this->navigationMapperMock->inputNavigationParent);
        self::assertSame('website', $this->navigationMapperMock->inputNavigationWebspaceKey);
        self::assertNull($this->navigationMapperMock->inputNavigationContext);
        self::assertSame('en', $this->navigationMapperMock->inputNavigationLocale);
        self::assertSame(1, $this->navigationMapperMock->inputNavigationDepth);
        self::assertFalse($this->navigationMapperMock->inputNavigationFlat);
        self::assertNull($this->navigationMapperMock->inputNavigationContext);
        self::assertFalse($this->navigationMapperMock->inputNavigationLoadExcerpt);
        self::assertNull($this->navigationMapperMock->inputNavigationSegmentKey);
        self::assertSame('website', $this->navigationMapperMock->inputNavigationRootWebspaceKey);
        self::assertNull($this->navigationMapperMock->inputNavigationRootContext);
        self::assertSame('en', $this->navigationMapperMock->inputNavigationRootLocale);
        self::assertSame(1, $this->navigationMapperMock->inputNavigationRootDepth);
        self::assertFalse($this->navigationMapperMock->inputNavigationRootFlat);
        self::assertNull($this->navigationMapperMock->inputNavigationRootContext);
        self::assertFalse($this->navigationMapperMock->inputNavigationRootLoadExcerpt);
        self::assertNull($this->navigationMapperMock->inputNavigationRootSegmentKey);
    }

    public function testLoad_with_missing_navigation_template(): void
    {
        $rootNavigation = new RootNavigation('testTemplate');
        $subNavigation = new SubNavigation('testTemplate');
        $location = new Location('en');

        $expectedSubNavigation = [
            [
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_UUID_KEY => 'testUuid2'
            ],
            [
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_URL_KEY => 'testUrl'
            ]
        ];
        $this->navigationMapperMock->outputNavigationSubNavigation = $expectedSubNavigation;
        $expectedRootNavigation = [
            [
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_TEMPLATE_KEY => 'testTemplate2',
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_UUID_KEY => 'testUuid2'
            ],
            [
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_TEMPLATE_KEY => 'testTemplate',
                DefaultNavigationMediaUrlLoader::NAVIGATION_ITEM_UUID_KEY => 'testUuid'
            ]
        ];
        $this->navigationMapperMock->outputNavigationRootRootNavigation = $expectedRootNavigation;

        try {
            $this->defaultNavigationMediaUrlLoader->load($rootNavigation, $subNavigation, $location);
            $this->fail('EmptyStringException was expected to be thrown.');
        } catch (EmptyStringException $exception) {
            self::assertSame(
                'Validation failed for value "mediaNavigationUrl" with error: "Value for "mediaNavigationUrl" should not be empty."',
                $exception->getMessage()
            );
        }

        self::assertSame('testUuid', $this->navigationMapperMock->inputNavigationParent);
        self::assertSame('website', $this->navigationMapperMock->inputNavigationWebspaceKey);
        self::assertNull($this->navigationMapperMock->inputNavigationContext);
        self::assertSame('en', $this->navigationMapperMock->inputNavigationLocale);
        self::assertSame(1, $this->navigationMapperMock->inputNavigationDepth);
        self::assertFalse($this->navigationMapperMock->inputNavigationFlat);
        self::assertNull($this->navigationMapperMock->inputNavigationContext);
        self::assertFalse($this->navigationMapperMock->inputNavigationLoadExcerpt);
        self::assertNull($this->navigationMapperMock->inputNavigationSegmentKey);
        self::assertSame('website', $this->navigationMapperMock->inputNavigationRootWebspaceKey);
        self::assertNull($this->navigationMapperMock->inputNavigationRootContext);
        self::assertSame('en', $this->navigationMapperMock->inputNavigationRootLocale);
        self::assertSame(1, $this->navigationMapperMock->inputNavigationRootDepth);
        self::assertFalse($this->navigationMapperMock->inputNavigationRootFlat);
        self::assertNull($this->navigationMapperMock->inputNavigationRootContext);
        self::assertFalse($this->navigationMapperMock->inputNavigationRootLoadExcerpt);
        self::assertNull($this->navigationMapperMock->inputNavigationRootSegmentKey);
    }
}
