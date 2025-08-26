<?php

declare(strict_types=1);

namespace App\Database;

use Sulu\Bundle\WebsiteBundle\Navigation\NavigationMapperInterface;
use XingXingCoin\Core\Database\Model\NavigationUrl;
use XingXingCoin\Core\Database\NavigationUrlLoader as NavigationMediaUrlLoaderInterface;
use XingXingCoin\Core\Exception\EmptyStringException;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use XingXingCoin\Core\Model\Location;

final readonly class NavigationUrlLoader implements NavigationMediaUrlLoaderInterface
{
    public const string NAVIGATION_ITEM_TEMPLATE_KEY = 'template';
    public const string NAVIGATION_ITEM_UUID_KEY = 'uuid';
    public const string NAVIGATION_ITEM_URL_KEY = 'url';
    public const string WEBSPACE_KEY = 'website';

    public function __construct(
        private NavigationMapperInterface $navigationMapper
    ) {
    }

    /**
     * @throws EmptyStringException
     */
    #[\Override]
    public function load(
        RootNavigation $rootNavigation,
        SubNavigation $subNavigation,
        Location $location
    ): NavigationUrl {
        /** @var array<string, array<string, string>> $rootNavigationFromMapper */
        $rootNavigationFromMapper = $this->navigationMapper->getRootNavigation(
            self::WEBSPACE_KEY,
            $location->value
        );
        $rootNavigationItem = [];
        foreach ($rootNavigationFromMapper as $navigationItem) {
            $navigationTemplate = $navigationItem[self::NAVIGATION_ITEM_TEMPLATE_KEY] ?? '';
            if ($navigationTemplate === $rootNavigation->value) {
                $rootNavigationItem = $navigationItem;
            }
        }
        /** @var array<string, array<string, string>> $subNavigationFromMapper */
        $subNavigationFromMapper = $this->navigationMapper->getNavigation(
            $rootNavigationItem[self::NAVIGATION_ITEM_UUID_KEY] ?? '',
            self::WEBSPACE_KEY,
            $location->value
        );
        $subNavigationItem = [];
        foreach ($subNavigationFromMapper as $navigationItem) {
            $navigationTemplate = $navigationItem[self::NAVIGATION_ITEM_TEMPLATE_KEY] ?? '';
            if ($navigationTemplate === $subNavigation->value) {
                $subNavigationItem = $navigationItem;
            }
        }

        return new NavigationUrl($subNavigationItem[self::NAVIGATION_ITEM_URL_KEY] ?? '');
    }
}
