<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database;

use App\Database\DefaultNavigationUrlLoader;
use App\Tests\Unit\Database\Mocks\NavigationMapperMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use App\Database\Model\NavigationUrl;
use XingXingCoin\Core\Exception\EmptyStringException;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use XingXingCoin\Core\Model\Location;

#[CoversClass(DefaultNavigationUrlLoader::class)]
#[CoversClass(NavigationUrl::class)]
#[CoversClass(RootNavigation::class)]
#[CoversClass(SubNavigation::class)]
#[CoversClass(Location::class)]
final class DefaultNavigationMediaUrlLoaderTest extends TestCase
{
    private NavigationMapperMock $navigationMapperMock;
    private DefaultNavigationUrlLoader $defaultNavigationUrlLoader;

    protected function setUp(): void
    {
        $this->navigationMapperMock = new NavigationMapperMock();
        $this->defaultNavigationUrlLoader = new DefaultNavigationUrlLoader(
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
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_TEMPLATE_KEY => 'testTemplate2',
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_UUID_KEY => 'testUuid2'
            ],
            [
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_TEMPLATE_KEY => 'testTemplate',
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_URL_KEY => 'testUrl'
            ]
        ];
        $this->navigationMapperMock->outputNavigationSubNavigation = $expectedSubNavigation;
        $expectedRootNavigation = [
            [
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_TEMPLATE_KEY => 'testTemplate2',
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_UUID_KEY => 'testUuid2'
            ],
            [
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_TEMPLATE_KEY => 'testTemplate',
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_UUID_KEY => 'testUuid'
            ]
        ];
        $this->navigationMapperMock->outputNavigationRootRootNavigation = $expectedRootNavigation;

        $navigationUrl = $this->defaultNavigationUrlLoader->load($rootNavigation, $subNavigation, $location);

        self::assertSame('testUrl', $navigationUrl->value);
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
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_UUID_KEY => 'testUuid2'
            ],
            [
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_URL_KEY => 'testUrl'
            ]
        ];
        $this->navigationMapperMock->outputNavigationSubNavigation = $expectedSubNavigation;
        $expectedRootNavigation = [
            [
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_TEMPLATE_KEY => 'testTemplate2',
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_UUID_KEY => 'testUuid2'
            ],
            [
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_TEMPLATE_KEY => 'testTemplate',
                DefaultNavigationUrlLoader::NAVIGATION_ITEM_UUID_KEY => 'testUuid'
            ]
        ];
        $this->navigationMapperMock->outputNavigationRootRootNavigation = $expectedRootNavigation;

        try {
            $this->defaultNavigationUrlLoader->load($rootNavigation, $subNavigation, $location);
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
