<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Gallery;

use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\MediaUrlCollection;

interface MediaUrlCollectionByFilterGenerator
{
    public function generate(MediaCollection $mediaCollection): MediaUrlCollection;
}
