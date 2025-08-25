<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Gallery;

use App\Gallery\Model\MediaUrlCollection;

interface MediaUrlCollectionRandomizer
{
    public function randomize(array $mediaUrlData): MediaUrlCollection;
}
