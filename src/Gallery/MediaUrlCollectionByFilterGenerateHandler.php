<?php

declare(strict_types=1);

namespace App\Gallery;

use App\Gallery\Model\ImageFilter;
use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\MediaUrlCollection;

interface MediaUrlCollectionByFilterGenerateHandler
{
    public function handle(MediaCollection $mediaCollection, ImageFilter $imageFilter): MediaUrlCollection;
}
