<?php

declare(strict_types=1);

namespace Xingxingcoin\Core\Database;

use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Xingxingcoin\Core\Database\Exception\PageDocumentNotLoadedException;

interface DocumentByPathLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     */
    public function load(string $path): BasePageDocument;
}
