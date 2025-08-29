<?php

declare(strict_types=1);

namespace App\Database;

use App\Database\Exception\MediaNotFoundException;
use App\Database\Model\Location;
use App\Database\Model\MediaId;
use Sulu\Bundle\MediaBundle\Api\Media;

interface MediaByMediaIdLoader
{
    /**
     * @throws MediaNotFoundException
     */
    public function load(MediaId $mediaId, Location $location): Media;
}
