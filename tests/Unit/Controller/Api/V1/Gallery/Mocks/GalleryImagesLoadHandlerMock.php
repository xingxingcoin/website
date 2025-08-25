<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Gallery\Mocks;

use App\Data\Exception\PageDocumentNotLoadedException;
use Xingxingcoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use Xingxingcoin\Core\Gallery\GalleryImagesLoadHandler;
use Xingxingcoin\Core\Gallery\Model\ImageCounter;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;
use Xingxingcoin\Core\Model\Location;

final class GalleryImagesLoadHandlerMock implements GalleryImagesLoadHandler
{
    public Location $inputLocation;
    public ImageCounter $inputImageCounter;
    public MediaUrlCollection $outputMediaUrlCollection;
    public ?PageDocumentNotLoadedException $throwPageDocumentNotLoadedException = null;
    public ?MediaUrlNotLoadedException $throwMediaUrlNotLoadedException = null;

    /**
     * @throws MediaUrlNotLoadedException
     * @throws PageDocumentNotLoadedException
     */
    public function handle(Location $location, ImageCounter $imageCounter): MediaUrlCollection
    {
        $this->inputLocation = $location;
        $this->inputImageCounter = $imageCounter;
        if ($this->throwPageDocumentNotLoadedException instanceof PageDocumentNotLoadedException) {
            throw $this->throwPageDocumentNotLoadedException;
        }
        if ($this->throwMediaUrlNotLoadedException instanceof  MediaUrlNotLoadedException) {
            throw $this->throwMediaUrlNotLoadedException;
        }

        return $this->outputMediaUrlCollection;
    }
}
