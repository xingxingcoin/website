<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Gallery\Mocks;

use App\Controller\Api\V1\Gallery\MemeGeneratorImagesLoadHandler;
use App\Gallery\Exception\MediaUrlNotLoadedException;
use App\Gallery\Exception\PageDocumentNotLoadedException;
use App\Gallery\Model\ImageCounter;
use App\Gallery\Model\Location;
use App\Gallery\Model\MediaUrlCollection;

final class MemeGeneratorImagesLoadHandlerMock implements MemeGeneratorImagesLoadHandler
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
