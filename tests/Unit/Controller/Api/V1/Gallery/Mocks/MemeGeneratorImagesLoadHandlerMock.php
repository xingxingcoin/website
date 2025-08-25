<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Gallery\Mocks;

use XingXingCoin\Core\Database\Exception\PageDocumentNotLoadedException;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\MemeGeneratorImagesLoadHandler;
use XingXingCoin\Core\Gallery\Model\ImageCounter;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use XingXingCoin\Core\Model\Location;

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
