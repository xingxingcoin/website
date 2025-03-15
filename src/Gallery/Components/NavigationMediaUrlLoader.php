<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use App\Gallery\Model\Location;
use App\Gallery\Model\MediaNavigationUrl;
use App\Gallery\Model\RootNavigation;
use App\Gallery\Model\SubNavigation;

interface NavigationMediaUrlLoader
{
    public function load(
        RootNavigation $rootNavigation,
        SubNavigation $subNavigation,
        Location $location
    ): MediaNavigationUrl;
}
