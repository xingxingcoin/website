<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Gallery;

use App\Gallery\Exception\MediaUrlNotLoadedException;
use App\Gallery\Exception\PageDocumentNotLoadedException;
use App\Gallery\Model\ImageCounter;
use App\Gallery\Model\Location;
use App\Gallery\Model\MediaUrlCollection;

interface MemeGeneratorImagesLoadHandler
{
    /**
     * @throws PageDocumentNotLoadedException
     * @throws MediaUrlNotLoadedException
     */
    public function handle(Location $location, ImageCounter $imageCounter): MediaUrlCollection;
}
