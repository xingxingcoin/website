<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Gallery;

use App\Database\Exception\MediaNotFoundException;
use App\Database\Model\Location;
use App\Database\Model\RootNavigation;
use App\Database\Model\SubNavigation;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use XingXingCoin\Core\Exception\EmptyStringException;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

interface MediaUrlCollectionByDocumentLoader
{
    /**
     * @throws MediaUrlNotLoadedException
     * @throws MediaNotFoundException
     * @throws EmptyStringException
     */
    public function load(BasePageDocument $document, Location $location, RootNavigation $rootNavigation, SubNavigation $subNavigation): MediaUrlCollection;
}
