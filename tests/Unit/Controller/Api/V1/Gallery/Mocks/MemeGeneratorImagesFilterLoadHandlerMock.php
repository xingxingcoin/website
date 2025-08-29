<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Gallery\Mocks;

use App\Database\Exception\MediaNotFoundException;
use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\Location;
use XingXingCoin\Core\Gallery\Exception\MediaDataNotLoadedException;
use XingXingCoin\Core\Gallery\MemeGeneratorImagesFilterLoadHandler;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\ImageFilter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

final class MemeGeneratorImagesFilterLoadHandlerMock implements MemeGeneratorImagesFilterLoadHandler
{
    public Location $inputLocation;
    public ImageCounter $inputImageCounter;
    public MediaUrlCollection $outputMediaUrlCollection;
    public ?PageDocumentNotLoadedException $throwPageDocumentNotLoadedException = null;
    public ?MediaDataNotLoadedException $throwMediaDataNotLoadedException = null;
    public ?MediaNotFoundException $throwMediaNotFoundException = null;

    /**
     * @throws MediaDataNotLoadedException
     * @throws MediaNotFoundException
     * @throws PageDocumentNotLoadedException
     */
    public function handle(Location $location, ImageCounter $imageCounter, ImageFilter $imageFilter): MediaUrlCollection
    {
        $this->inputLocation = $location;
        $this->inputImageCounter = $imageCounter;
        if ($this->throwPageDocumentNotLoadedException instanceof PageDocumentNotLoadedException) {
            throw $this->throwPageDocumentNotLoadedException;
        }
        if ($this->throwMediaDataNotLoadedException instanceof MediaDataNotLoadedException) {
            throw $this->throwMediaDataNotLoadedException;
        }
        if ($this->throwMediaNotFoundException instanceof MediaNotFoundException) {
            throw $this->throwMediaNotFoundException;
        }

        return $this->outputMediaUrlCollection;
    }
}
