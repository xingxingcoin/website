<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use App\Gallery\MediaUrlCollectionRandomizer as MediaUrlCollectionRandomizerInterface;
use App\Gallery\Model\MediaUrlCollection;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final readonly class MediaUrlCollectionRandomizer implements MediaUrlCollectionRandomizerInterface
{
    #[\Override]
    public function randomize(array $mediaUrlData): MediaUrlCollection
    {
        shuffle($mediaUrlData);
        return new MediaUrlCollection($mediaUrlData);
    }
}
