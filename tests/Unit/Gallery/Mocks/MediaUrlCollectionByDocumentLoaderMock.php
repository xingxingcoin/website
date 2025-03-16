<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Mocks;

use App\Gallery\MediaUrlCollectionByDocumentLoader;
use App\Gallery\Model\Location;
use App\Gallery\Model\MediaUrlCollection;
use App\Gallery\Model\RootNavigation;
use App\Gallery\Model\SubNavigation;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;

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
