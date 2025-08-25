<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Gallery;

use XingXingCoin\Core\Gallery\Model\MediaNavigationUrl;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use XingXingCoin\Core\Model\Location;
use XingXingCoin\JsonValidator\Validation\Exception\EmptyStringException;

interface NavigationMediaUrlLoader
{
    /**
     * @throws EmptyStringException
     */
    public function load(
        RootNavigation $rootNavigation,
        SubNavigation $subNavigation,
        Location $location
    ): MediaNavigationUrl;
}
