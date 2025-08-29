<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Mocks;

use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use XingXingCoin\Core\Gallery\MediaCollectionByDocumentLoader;
use XingXingCoin\Core\Gallery\Model\MediaCollection;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use App\Model\Location;

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
