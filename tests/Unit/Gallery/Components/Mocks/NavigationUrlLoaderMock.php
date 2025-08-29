<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components\Mocks;

use App\Database\Model\NavigationUrl;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use App\Database\NavigationUrlLoader;
use App\Model\Location;

final class NavigationUrlLoaderMock implements NavigationUrlLoader
{
    public RootNavigation $inputRootNavigation;
    public SubNavigation $inputSubNavigation;
    public Location $inputLocation;
    public NavigationUrl $outputNavigationUrl;

    public function load(RootNavigation $rootNavigation, SubNavigation $subNavigation, Location $location): NavigationUrl
    {
        $this->inputRootNavigation = $rootNavigation;
        $this->inputSubNavigation = $subNavigation;
        $this->inputLocation = $location;

        return $this->outputNavigationUrl;
    }
}
