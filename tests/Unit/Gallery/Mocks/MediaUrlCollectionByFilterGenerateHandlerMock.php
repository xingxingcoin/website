<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Mocks;

use Xingxingcoin\Core\Gallery\MediaUrlCollectionByFilterGenerateHandler;
use Xingxingcoin\Core\Gallery\Model\ImageFilter;
use Xingxingcoin\Core\Gallery\Model\MediaCollection;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

final class MediaUrlCollectionByFilterGenerateHandlerMock implements MediaUrlCollectionByFilterGenerateHandler
{
    public MediaCollection $inputMediaCollection;
    public ImageFilter $inputImageFilter;
    public MediaUrlCollection $outputMediaUrlCollection;

    public function handle(MediaCollection $mediaCollection, ImageFilter $imageFilter): MediaUrlCollection
    {
        $this->inputMediaCollection = $mediaCollection;
        $this->inputImageFilter = $imageFilter;

        return $this->outputMediaUrlCollection;
    }
}
