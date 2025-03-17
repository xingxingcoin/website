<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components\Mocks;

use App\Gallery\Components\MediaUrlCollectionByFilterGenerator;
use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\MediaUrlCollection;

final class MediaUrlCollectionByFilterGeneratorMock implements MediaUrlCollectionByFilterGenerator
{
    public MediaCollection $inputMediaCollection;
    public MediaUrlCollection $outputMediaUrlCollection;

    public function generate(MediaCollection $mediaCollection): MediaUrlCollection
    {
        $this->inputMediaCollection = $mediaCollection;

        return $this->outputMediaUrlCollection;
    }
}
