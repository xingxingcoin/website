<?php

declare(strict_types=1);

namespace App\Gallery;

use App\Gallery\Model\MediaUrlCollection;

interface MediaUrlCollectionRandomizer
{
    public function randomize(array $mediaUrlData): MediaUrlCollection;
}
