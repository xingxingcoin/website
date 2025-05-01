<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Gallery;

use App\Gallery\Exception\MediaUrlNotLoadedException;
use App\Gallery\Model\ImageCounter;
use App\Gallery\Model\MediaUrlCollection;
use App\Model\Location;
use App\Data\Exception\PageDocumentNotLoadedException;

interface MemeGeneratorImagesLoadHandler
{
    /**
     * @throws PageDocumentNotLoadedException
     * @throws MediaUrlNotLoadedException
     */
    public function handle(Location $location, ImageCounter $imageCounter): MediaUrlCollection;
}
