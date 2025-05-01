<?php

declare(strict_types=1);

namespace App\Data;

use App\Data\Exception\PageDocumentNotLoadedException;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;

interface DocumentByPathLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     */
    public function load(string $path): BasePageDocument;
}
