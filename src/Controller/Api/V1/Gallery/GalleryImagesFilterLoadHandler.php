<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Gallery;

use App\Gallery\Exception\MediaDataNotLoadedException;
use App\Gallery\Exception\PageDocumentNotLoadedException;
use App\Gallery\Model\ImageCounter;
use App\Gallery\Model\ImageFilter;
use App\Gallery\Model\Location;
use App\Gallery\Model\MediaUrlCollection;

interface GalleryImagesFilterLoadHandler
{
    /**
     * @throws MediaDataNotLoadedException
     * @throws PageDocumentNotLoadedException
     */
    public function handle(Location $location, ImageCounter $imageCounter, ImageFilter $imageFilter): MediaUrlCollection;
}
