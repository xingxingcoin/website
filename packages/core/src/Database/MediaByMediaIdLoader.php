<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Database;

use Sulu\Bundle\MediaBundle\Api\Media;
use XingXingCoin\Core\Database\Exception\MediaNotFoundException as MediaByMediaIdNotFoundException;
use XingXingCoin\Core\Model\Location;
use XingXingCoin\Core\Database\Model\MediaId;

interface MediaByMediaIdLoader
{
    /**
     * @throws MediaByMediaIdNotFoundException
     */
    public function load(MediaId $mediaId, Location $location): Media;
}
