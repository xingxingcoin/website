<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Database;

use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use XingXingCoin\Core\Database\Exception\PageDocumentNotLoadedException;
use XingXingCoin\Core\Database\Model\DocumentPath;

interface DocumentByPathLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     */
    public function load(DocumentPath $documentPath): BasePageDocument;
}
