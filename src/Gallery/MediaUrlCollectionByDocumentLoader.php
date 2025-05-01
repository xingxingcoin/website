<?php

declare(strict_types=1);

namespace App\Gallery;

use App\Gallery\Exception\MediaUrlNotLoadedException;
use App\Gallery\Model\MediaUrlCollection;
use App\Gallery\Model\RootNavigation;
use App\Gallery\Model\SubNavigation;
use App\Model\Location;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;

interface MediaUrlCollectionByDocumentLoader
{
    /**
     * @throws MediaUrlNotLoadedException
     */
    public function load(BasePageDocument $document, Location $location, RootNavigation $rootNavigation, SubNavigation $subNavigation): MediaUrlCollection;
}
