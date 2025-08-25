<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Mocks;

use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use XingXingCoin\Core\Gallery\MediaUrlCollectionByDocumentLoader;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use XingXingCoin\Core\Model\Location;

final class MediaUrlCollectionByDocumentLoaderMock implements MediaUrlCollectionByDocumentLoader
{
    public BasePageDocument $inputDocument;
    public Location $inputLocation;
    public RootNavigation $inputRootNavigation;
    public SubNavigation $inputSubNavigation;
    public MediaUrlCollection $outputMediaUrlCollection;

    public function load(BasePageDocument $document, Location $location, RootNavigation $rootNavigation, SubNavigation $subNavigation): MediaUrlCollection
    {
        $this->inputDocument = $document;
        $this->inputLocation = $location;
        $this->inputRootNavigation = $rootNavigation;
        $this->inputSubNavigation = $subNavigation;

        return $this->outputMediaUrlCollection;
    }
}
