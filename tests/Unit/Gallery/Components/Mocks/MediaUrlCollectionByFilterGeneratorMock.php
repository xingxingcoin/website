<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Components\Mocks;

use Xingxingcoin\Core\Gallery\MediaUrlCollectionByFilterGenerator;
use Xingxingcoin\Core\Gallery\Model\MediaCollection;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

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
