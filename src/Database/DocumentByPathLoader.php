<?php

declare(strict_types=1);

namespace App\Database;

use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\DocumentPath;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;

interface DocumentByPathLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     */
    public function load(DocumentPath $documentPath): BasePageDocument;
}
