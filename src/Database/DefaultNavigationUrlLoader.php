<?php

declare(strict_types=1);

namespace App\Database;

use App\Database\Model\Location;
use App\Database\Model\NavigationUrl;
use App\Database\Model\RootNavigation;
use App\Database\Model\SubNavigation;
use App\Exception\EmptyStringException;
use Sulu\Bundle\WebsiteBundle\Navigation\NavigationMapperInterface;

final readonly class DefaultNavigationUrlLoader implements NavigationUrlLoader
{
    public const string NAVIGATION_ITEM_TEMPLATE_KEY = 'template';
    public const string NAVIGATION_ITEM_UUID_KEY = 'uuid';
    public const string NAVIGATION_ITEM_URL_KEY = 'url';
    public const string WEBSPACE_KEY = 'website';

    public function __construct(
        private NavigationMapperInterface $navigationMapper,
    ) {
    }

    /**
     * @throws EmptyStringException
     */
    #[\Override]
    public function load(
        RootNavigation $rootNavigation,
        SubNavigation $subNavigation,
        Location $location,
    ): NavigationUrl {
        /** @var array<string, array<string, string>> $rootNavigationFromMapper */
        $rootNavigationFromMapper = $this->navigationMapper->getRootNavigation(
            self::WEBSPACE_KEY,
            $location->value,
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
            $location->value,
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
