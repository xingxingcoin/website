<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Gallery;

use XingXingCoin\Core\Gallery\Model\ImageFilter;
use XingXingCoin\Core\Gallery\Model\MediaCollection;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;

interface MediaUrlCollectionByFilterGenerateHandler
{
    public function handle(MediaCollection $mediaCollection, ImageFilter $imageFilter): MediaUrlCollection;
}
