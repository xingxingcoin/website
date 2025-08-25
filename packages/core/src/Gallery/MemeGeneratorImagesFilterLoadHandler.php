<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Gallery;

use App\Data\Exception\PageDocumentNotLoadedException;
use Xingxingcoin\Core\Gallery\Exception\MediaDataNotLoadedException;
use Xingxingcoin\Core\Gallery\Model\ImageCounter;
use Xingxingcoin\Core\Gallery\Model\ImageFilter;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;
use Xingxingcoin\Core\Model\Location;

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
