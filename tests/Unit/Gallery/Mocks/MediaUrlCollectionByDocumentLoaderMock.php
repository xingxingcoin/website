<?php

declare(strict_types=1);

namespace App\Tests\Unit\Gallery\Mocks;

use App\Gallery\MediaUrlCollectionByDocumentLoader;
use App\Gallery\Model\Location;
use App\Gallery\Model\MediaUrlCollection;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;

final class MediaUrlCollectionByDocumentLoaderMock implements MediaUrlCollectionByDocumentLoader
{
    public BasePageDocument $inputDocument;
    public Location $inputLocation;
    public MediaUrlCollection $outputMediaUrlCollection;

    public function load(BasePageDocument $document, Location $location): MediaUrlCollection
    {
        $this->inputDocument = $document;
        $this->inputLocation = $location;

        return $this->outputMediaUrlCollection;
    }
}
