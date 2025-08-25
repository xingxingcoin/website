<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Gallery;

use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

interface MediaUrlCollectionRandomizer
{
    public function randomize(array $mediaUrlData): MediaUrlCollection;
}
