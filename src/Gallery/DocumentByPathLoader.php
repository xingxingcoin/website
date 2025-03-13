<?php

declare(strict_types=1);

namespace App\Gallery;

use App\Gallery\Exception\PageDocumentNotLoadedException;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;

interface DocumentByPathLoader
{
    /**
     * @throws PageDocumentNotLoadedException
     */
    public function load(string $path): BasePageDocument;
}
