<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database\Mocks;

use Sulu\Component\DocumentManager\DocumentManagerInterface;
use Sulu\Component\DocumentManager\Exception\DocumentManagerException;
use Sulu\Component\DocumentManager\Query\Query;

final class DocumentManagerMock implements DocumentManagerInterface
{
    public ?string $inputIdentifier;
    public ?string $inputLocale;
    public array $inputOptions;
    public object $outputFind;
    public ?DocumentManagerException $throwDocumentManagerException = null;

    /**
     * @throws DocumentManagerException
     */
    public function find($identifier, $locale = null, array $options = []): object
    {
        $this->inputIdentifier = $identifier;
        $this->inputLocale = $locale;
        $this->inputOptions = $options;
        if ($this->throwDocumentManagerException instanceof DocumentManagerException) {
            throw $this->throwDocumentManagerException;
        }

        return $this->outputFind;
    }

    public function create($alias): object
    {
        // TODO: Implement create() method.
    }

    public function persist($document, $locale = null, array $options = []): void
    {
        // TODO: Implement persist() method.
    }

    public function remove($document): void
    {
        // TODO: Implement remove() method.
    }

    public function removeLocale($document, $locale): void
    {
        // TODO: Implement removeLocale() method.
    }

    public function move($document, $destId): void
    {
        // TODO: Implement move() method.
    }

    public function copy($document, $destPath): ?string
    {
        // TODO: Implement copy() method.
    }

    public function copyLocale($document, $srcLocale, $destLocale): void
    {
        // TODO: Implement copyLocale() method.
    }

    public function reorder($document, $destId): void
    {
        // TODO: Implement reorder() method.
    }

    public function publish($document, $locale = null, array $options = []): void
    {
        // TODO: Implement publish() method.
    }

    public function unpublish($document, $locale): void
    {
        // TODO: Implement unpublish() method.
    }

    public function removeDraft($document, $locale): void
    {
        // TODO: Implement removeDraft() method.
    }

    public function restore($document, $locale, $version, array $options = []): void
    {
        // TODO: Implement restore() method.
    }

    public function refresh($document): void
    {
        // TODO: Implement refresh() method.
    }

    public function flush(): void
    {
        // TODO: Implement flush() method.
    }

    public function clear(): void
    {
        // TODO: Implement clear() method.
    }

    public function createQuery($query, $locale = null, array $options = []): Query
    {
        // TODO: Implement createQuery() method.
    }
}
