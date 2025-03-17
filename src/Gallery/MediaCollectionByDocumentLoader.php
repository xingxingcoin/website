<?php

declare(strict_types=1);

namespace App\Gallery;

use App\Gallery\Exception\MediaDataNotLoadedException;
use App\Gallery\Model\Location;
use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\RootNavigation;
use App\Gallery\Model\SubNavigation;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;

interface MediaCollectionByDocumentLoader
{
    /**
     * @throws MediaDataNotLoadedException
     */
    public function load(BasePageDocument $document, Location $location, RootNavigation $rootNavigation, SubNavigation $subNavigation): MediaCollection;
}
