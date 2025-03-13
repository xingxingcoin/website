<?php

declare(strict_types=1);

namespace App\Gallery;

use App\Gallery\Exception\MediaUrlNotLoadedException;
use App\Gallery\Model\Location;
use App\Gallery\Model\MediaUrlCollection;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;

interface MediaUrlCollectionByDocumentLoader
{
    /**
     * @throws MediaUrlNotLoadedException
     */
    public function load(BasePageDocument $document, Location $location): MediaUrlCollection;
}
