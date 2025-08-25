<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Gallery;

use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use XingXingCoin\Core\Model\Location;

interface MediaUrlCollectionByDocumentLoader
{
    /**
     * @throws MediaUrlNotLoadedException
     */
    public function load(BasePageDocument $document, Location $location, RootNavigation $rootNavigation, SubNavigation $subNavigation): MediaUrlCollection;
}
