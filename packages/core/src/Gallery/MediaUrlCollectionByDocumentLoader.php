<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Gallery;

use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Xingxingcoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;
use Xingxingcoin\Core\Gallery\Model\RootNavigation;
use Xingxingcoin\Core\Gallery\Model\SubNavigation;
use Xingxingcoin\Core\Model\Location;

interface MediaUrlCollectionByDocumentLoader
{
    /**
     * @throws MediaUrlNotLoadedException
     */
    public function load(BasePageDocument $document, Location $location, RootNavigation $rootNavigation, SubNavigation $subNavigation): MediaUrlCollection;
}
