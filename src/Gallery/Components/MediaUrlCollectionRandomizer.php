<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use Xingxingcoin\Core\Gallery\MediaUrlCollectionRandomizer as MediaUrlCollectionRandomizerInterface;
use Xingxingcoin\Core\Gallery\Model\MediaUrlCollection;

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
