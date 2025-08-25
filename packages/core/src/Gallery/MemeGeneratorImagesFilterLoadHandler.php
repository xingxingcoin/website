<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Gallery;

use XingXingCoin\Core\Database\Exception\PageDocumentNotLoadedException;
use XingXingCoin\Core\Gallery\Exception\MediaDataNotLoadedException;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\ImageFilter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use XingXingCoin\Core\Model\Location;

interface MemeGeneratorImagesFilterLoadHandler
{
    /**
     * @throws MediaDataNotLoadedException
     * @throws PageDocumentNotLoadedException
     */
    public function handle(
        Location $location,
        ImageCounter $imageCounter,
        ImageFilter $imageFilter
    ): MediaUrlCollection;
}
