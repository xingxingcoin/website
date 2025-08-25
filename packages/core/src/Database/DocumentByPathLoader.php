<?php

declare(strict_types=1);

namespace XingXingCoin\Core\Database;

use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use XingXingCoin\Core\Database\Exception\PageDocumentNotLoadedException;

interface DocumentByPathLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     */
    public function load(string $path): BasePageDocument;
}
