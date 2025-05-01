<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Gallery;

use App\Gallery\Exception\MediaDataNotLoadedException;
use App\Gallery\Model\ImageCounter;
use App\Gallery\Model\ImageFilter;
use App\Gallery\Model\MediaUrlCollection;
use App\Model\Location;
use App\Data\Exception\PageDocumentNotLoadedException;

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
