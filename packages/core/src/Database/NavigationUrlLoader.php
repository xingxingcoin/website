<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Database;

use XingXingCoin\Core\Database\Model\NavigationUrl;
use XingXingCoin\Core\Exception\EmptyStringException;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use XingXingCoin\Core\Model\Location;

interface NavigationUrlLoader
{
    /**
     * @throws EmptyStringException
     */
    public function load(
        RootNavigation $rootNavigation,
        SubNavigation $subNavigation,
        Location $location
    ): NavigationUrl;
}
