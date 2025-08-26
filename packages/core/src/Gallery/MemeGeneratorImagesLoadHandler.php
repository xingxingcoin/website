<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Gallery;

use XingXingCoin\Core\Database\Exception\PageDocumentNotLoadedException;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use XingXingCoin\Core\Model\Location;
use XingXingCoin\Core\Exception\EmptyStringException;

interface MemeGeneratorImagesLoadHandler
{
    /**
     * @throws PageDocumentNotLoadedException
     * @throws MediaUrlNotLoadedException
     * @throws EmptyStringException
     */
    public function handle(Location $location, ImageCounter $imageCounter): MediaUrlCollection;
}
