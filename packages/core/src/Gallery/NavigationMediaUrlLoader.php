<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Gallery;

use Xingxingcoin\Core\Gallery\Model\MediaNavigationUrl;
use Xingxingcoin\Core\Gallery\Model\RootNavigation;
use Xingxingcoin\Core\Gallery\Model\SubNavigation;
use Xingxingcoin\Core\Model\Location;
use Xingxingcoin\JsonValidator\Validation\Exception\EmptyStringException;

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
