<?php

declare(strict_types=1);

namespace App\Database;

use App\Database\Model\Location;
use App\Database\Model\NavigationUrl;
use App\Database\Model\RootNavigation;
use App\Database\Model\SubNavigation;
use App\Exception\EmptyStringException;

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
