<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Gallery;

use Xingxingcoin\Core\Gallery\Model\MediaNavigationUrl;
use Xingxingcoin\Core\Gallery\Model\RootNavigation;
use Xingxingcoin\Core\Gallery\Model\SubNavigation;
use Xingxingcoin\Core\Model\Location;

interface NavigationMediaUrlLoader
{
    public function load(
        RootNavigation $rootNavigation,
        SubNavigation $subNavigation,
        Location $location
    ): MediaNavigationUrl;
}
