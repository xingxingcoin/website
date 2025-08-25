<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Gallery;

use Xingxingcoin\Core\Gallery\Model\MediaCollection;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

interface MediaUrlCollectionByFilterGenerator
{
    public function generate(MediaCollection $mediaCollection): MediaUrlCollection;
}
