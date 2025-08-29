<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components\Mocks;

use App\Database\Exception\MediaNotFoundException;
use App\Database\MediaByMediaIdLoader;
use App\Database\Model\Location;
use App\Database\Model\MediaId;
use Sulu\Bundle\MediaBundle\Api\Media;

final class MediaByMediaIdLoaderMock implements MediaByMediaIdLoader
{
    public MediaId $inputMediaId;
    public Location $inputLocation;
    public Media $outputMedia;
    public ?MediaNotFoundException $throwMediaNotFoundException = null;

    /**
     * @throws MediaNotFoundException
     */
    public function load(MediaId $mediaId, Location $location): Media
    {
        $this->inputMediaId = $mediaId;
        $this->inputLocation = $location;
        if ($this->throwMediaNotFoundException instanceof MediaNotFoundException) {
            throw $this->throwMediaNotFoundException;
        }

        return $this->outputMedia;
    }
}
