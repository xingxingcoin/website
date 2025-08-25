<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components\Mocks;

use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\MediaUrlCollection;
use Xingxingcoin\Core\Gallery\MediaUrlCollectionByFilterGenerator;

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
