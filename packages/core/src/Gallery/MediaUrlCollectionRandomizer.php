<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Gallery;

use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

interface MediaUrlCollectionRandomizer
{
    public function randomize(array $mediaUrlData): MediaUrlCollection;
}
