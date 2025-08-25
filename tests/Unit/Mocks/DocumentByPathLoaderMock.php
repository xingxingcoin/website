<?php

declare(strict_types=1);

namespace App\Tests\Unit\Mocks;

use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Xingxingcoin\Core\Database\DocumentByPathLoader;

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
