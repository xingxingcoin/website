<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use App\Exception\EmptyStringException;
use App\Gallery\Model\MediaNavigationUrl;
use App\Gallery\Model\RootNavigation;
use App\Gallery\Model\SubNavigation;
use Sulu\Bundle\WebsiteBundle\Navigation\NavigationMapperInterface;
use Xingxingcoin\Core\Gallery\NavigationMediaUrlLoader;
use Xingxingcoin\Core\Model\Location;

final readonly class DefaultNavigationMediaUrlLoader implements NavigationMediaUrlLoader
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
    ): MediaNavigationUrl {
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

        return new MediaNavigationUrl($subNavigationItem[self::NAVIGATION_ITEM_URL_KEY] ?? '');
    }
}
