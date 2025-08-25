<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Mocks;

use App\Gallery\Model\MediaUrlCollection;
use Xingxingcoin\Core\Gallery\MediaUrlCollectionRandomizer;

final class MediaUrlCollectionRandomizerMock implements MediaUrlCollectionRandomizer
{
    public array $inputMediaUrlData;
    public MediaUrlCollection $outputMediaUrlCollection;

    public function randomize(array $mediaUrlData): MediaUrlCollection
    {
        $this->inputMediaUrlData = $mediaUrlData;

        return $this->outputMediaUrlCollection;
    }
}
