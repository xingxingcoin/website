<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Gallery;

use App\Gallery\Exception\MediaUrlNotLoadedException;
use App\Gallery\Model\MediaUrlCollection;
use App\Gallery\Model\RootNavigation;
use App\Gallery\Model\SubNavigation;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Xingxingcoin\Core\Model\Location;

interface MediaUrlCollectionByDocumentLoader
{
    /**
     * @throws MediaUrlNotLoadedException
     */
    public function load(BasePageDocument $document, Location $location, RootNavigation $rootNavigation, SubNavigation $subNavigation): MediaUrlCollection;
}
