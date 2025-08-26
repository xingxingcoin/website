<?php

declare(strict_types=1);

namespace App\Tests\Unit\Mocks;

use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use XingXingCoin\Core\Database\DocumentByPathLoader;
use XingXingCoin\Core\Database\Model\DocumentPath;

final class DocumentByPathLoaderMock implements DocumentByPathLoader
{
    public DocumentPath $inputDocumentPath;
    public BasePageDocument $outputBasePageDocument;

    public function load(DocumentPath $documentPath): BasePageDocument
    {
        $this->inputDocumentPath = $documentPath;

        return $this->outputBasePageDocument;
    }
}
