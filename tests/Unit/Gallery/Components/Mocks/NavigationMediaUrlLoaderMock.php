<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components\Mocks;

use App\Gallery\Components\NavigationMediaUrlLoader;
use App\Gallery\Model\Location;
use App\Gallery\Model\MediaNavigationUrl;
use App\Gallery\Model\RootNavigation;
use App\Gallery\Model\SubNavigation;

final class NavigationMediaUrlLoaderMock implements NavigationMediaUrlLoader
{
    public RootNavigation $inputRootNavigation;
    public SubNavigation $inputSubNavigation;
    public Location $inputLocation;
    public MediaNavigationUrl $outputMediaNavigationUrl;

    public function load(RootNavigation $rootNavigation, SubNavigation $subNavigation, Location $location): MediaNavigationUrl
    {
        $this->inputRootNavigation = $rootNavigation;
        $this->inputSubNavigation = $subNavigation;
        $this->inputLocation = $location;

        return $this->outputMediaNavigationUrl;
    }
}
