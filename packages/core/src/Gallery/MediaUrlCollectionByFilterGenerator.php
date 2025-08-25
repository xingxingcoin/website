<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Gallery;

use XingXingCoin\Core\Gallery\Model\MediaCollection;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

interface MediaUrlCollectionByFilterGenerator
{
    public function generate(MediaCollection $mediaCollection): MediaUrlCollection;
}
