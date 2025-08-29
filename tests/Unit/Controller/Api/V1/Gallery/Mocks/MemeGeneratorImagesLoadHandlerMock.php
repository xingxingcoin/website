<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Gallery\Mocks;

use App\Database\Exception\MediaNotFoundException;
use App\Database\Exception\PageDocumentNotLoadedException;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\MemeGeneratorImagesLoadHandler;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use App\Model\Location;

final class MemeGeneratorImagesLoadHandlerMock implements MemeGeneratorImagesLoadHandler
{
    public Location $inputLocation;
    public ImageCounter $inputImageCounter;
    public MediaUrlCollection $outputMediaUrlCollection;
    public ?PageDocumentNotLoadedException $throwPageDocumentNotLoadedException = null;
    public ?MediaUrlNotLoadedException $throwMediaUrlNotLoadedException = null;
    public ?MediaNotFoundException $throwMediaNotFoundException = null;

    /**
     * @throws MediaNotFoundException
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
        if ($this->throwMediaUrlNotLoadedException instanceof MediaUrlNotLoadedException) {
            throw $this->throwMediaUrlNotLoadedException;
        }
        if ($this->throwMediaNotFoundException instanceof MediaNotFoundException) {
            throw $this->throwMediaNotFoundException;
        }

        return $this->outputMediaUrlCollection;
    }
}
