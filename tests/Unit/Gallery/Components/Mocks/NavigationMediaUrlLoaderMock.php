<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components\Mocks;

use Xingxingcoin\Core\Gallery\Model\MediaNavigationUrl;
use Xingxingcoin\Core\Gallery\Model\RootNavigation;
use Xingxingcoin\Core\Gallery\Model\SubNavigation;
use Xingxingcoin\Core\Gallery\NavigationMediaUrlLoader;
use Xingxingcoin\Core\Model\Location;

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
