<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use Sulu\Bundle\WebsiteBundle\Navigation\NavigationMapperInterface;
use Xingxingcoin\Core\Gallery\Model\MediaNavigationUrl;
use Xingxingcoin\Core\Gallery\Model\RootNavigation;
use Xingxingcoin\Core\Gallery\Model\SubNavigation;
use Xingxingcoin\Core\Gallery\NavigationMediaUrlLoader;
use Xingxingcoin\Core\Model\Location;
use Xingxingcoin\JsonValidator\Validation\Exception\EmptyStringException;

final readonly class DefaultNavigationMediaUrlLoader implements NavigationMediaUrlLoader
{
    public const string NAVIGATION_ITEM_TEMPLATE_KEY = 'template';
    public const string NAVIGATION_ITEM_UUID_KEY = 'uuid';
    public const string NAVIGATION_ITEM_URL_KEY = 'url';
    public const string WEBSPACE_KEY = 'website';

    public function __construct(
        private NavigationMapperInterface $navigationMapper
    ) {}

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
