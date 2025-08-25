<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Api\V1\Gallery\Mocks;

use App\Controller\Api\V1\Gallery\MemeGeneratorImagesFilterLoadHandler;
use App\Data\Exception\PageDocumentNotLoadedException;
use App\Gallery\Exception\MediaDataNotLoadedException;
use App\Gallery\Model\ImageCounter;
use App\Gallery\Model\ImageFilter;
use App\Gallery\Model\MediaUrlCollection;
use Xingxingcoin\Core\Model\Location;

final class MemeGeneratorImagesFilterLoadHandlerMock implements MemeGeneratorImagesFilterLoadHandler
{
    public Location $inputLocation;
    public ImageCounter $inputImageCounter;
    public MediaUrlCollection $outputMediaUrlCollection;
    public ?PageDocumentNotLoadedException $throwPageDocumentNotLoadedException = null;
    public ?MediaDataNotLoadedException $throwMediaDataNotLoadedException = null;

    /**
     * @throws MediaDataNotLoadedException
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

        return $this->outputMediaUrlCollection;
    }
}
