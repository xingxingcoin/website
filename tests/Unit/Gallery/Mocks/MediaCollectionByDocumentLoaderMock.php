<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Mocks;

use App\Database\Model\Location;
use App\Database\Model\RootNavigation;
use App\Database\Model\SubNavigation;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use XingXingCoin\Core\Gallery\MediaCollectionByDocumentLoader;
use XingXingCoin\Core\Gallery\Model\MediaCollection;

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
