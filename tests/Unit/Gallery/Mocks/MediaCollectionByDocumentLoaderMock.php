<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Mocks;

use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Xingxingcoin\Core\Gallery\MediaCollectionByDocumentLoader;
use Xingxingcoin\Core\Gallery\Model\MediaCollection;
use Xingxingcoin\Core\Gallery\Model\RootNavigation;
use Xingxingcoin\Core\Gallery\Model\SubNavigation;
use Xingxingcoin\Core\Model\Location;

final class MediaCollectionByDocumentLoaderMock implements MediaCollectionByDocumentLoader
{
    public BasePageDocument $inputDocument;
    public Location $inputLocation;
    public RootNavigation $inputRootNavigation;
    public SubNavigation $inputSubNavigation;
    public MediaCollection $outputMediaCollection;

    public function load(
        BasePageDocument $document,
        Location $location,
        RootNavigation $rootNavigation,
        SubNavigation $subNavigation
    ): MediaCollection {
        $this->inputDocument = $document;
        $this->inputLocation = $location;
        $this->inputRootNavigation = $rootNavigation;
        $this->inputSubNavigation = $subNavigation;

        return $this->outputMediaCollection;
    }
}
