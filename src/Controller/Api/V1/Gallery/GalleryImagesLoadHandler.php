<?php
declare(strict_types=1);

namespace App\Controller\Api\V1\Gallery;

use App\Data\Exception\PageDocumentNotLoadedException;
use Xingxingcoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use Xingxingcoin\Core\Gallery\Model\ImageCounter;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;
use Xingxingcoin\Core\Model\Location;

interface GalleryImagesLoadHandler
{
    /**
     * @throws PageDocumentNotLoadedException
     * @throws MediaUrlNotLoadedException
     */
    public function handle(Location $location, ImageCounter $imageCounter): MediaUrlCollection;
}
