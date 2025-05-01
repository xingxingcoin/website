<?php

declare(strict_types=1);

namespace App\Tests\Unit\Mocks;

use App\Data\DocumentByPathLoader;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;

final class DocumentByPathLoaderMock implements DocumentByPathLoader
{
    public string $inputPath;
    public BasePageDocument $outputBasePageDocument;

    public function load(string $path): BasePageDocument
    {
        $this->inputPath = $path;

        return $this->outputBasePageDocument;
    }
}
