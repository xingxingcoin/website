<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Gallery;

use Xingxingcoin\Core\Gallery\Model\ImageFilter;
use Xingxingcoin\Core\Gallery\Model\MediaCollection;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

interface MediaUrlCollectionByFilterGenerateHandler
{
    public function handle(MediaCollection $mediaCollection, ImageFilter $imageFilter): MediaUrlCollection;
}
