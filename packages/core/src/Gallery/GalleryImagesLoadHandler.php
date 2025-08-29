<?php
declare(strict_types=1);

namespace XingXingCoin\Core\Gallery;

use App\Database\Exception\MediaNotFoundException;
use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\Location;
use App\Exception\EmptyStringException;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

interface GalleryImagesLoadHandler
{
    /**
     * @throws EmptyStringException
     * @throws MediaUrlNotLoadedException
     * @throws PageDocumentNotLoadedException
     * @throws MediaNotFoundException
     */
    public function handle(Location $location, ImageCounter $imageCounter): MediaUrlCollection;
}
