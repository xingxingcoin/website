<?php

declare(strict_types=1);

namespace App\Database;

use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\DocumentPath;

interface DocumentByPathLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     */
    public function load(DocumentPath $documentPath): BasePageDocument;
}
