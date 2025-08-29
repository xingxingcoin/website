<?php

declare(strict_types=1);

namespace App\Database;

use Sulu\Bundle\MediaBundle\Api\Media;
use App\Database\Exception\MediaNotFoundException;
use App\Model\Location;
use App\Database\Model\MediaId;

interface MediaByMediaIdLoader
{
    /**
     * @throws MediaNotFoundException
     */
    public function load(MediaId $mediaId, Location $location): Media;
}
