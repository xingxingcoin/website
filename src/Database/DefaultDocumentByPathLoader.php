<?php

declare(strict_types=1);

namespace App\Database;

use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\DocumentPath;
use Psr\Log\LoggerInterface;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\DocumentManager\DocumentManagerInterface;
use Sulu\Component\DocumentManager\Exception\DocumentManagerException;

final readonly class DefaultDocumentByPathLoader implements DocumentByPathLoader
{
    public function __construct(
        private DocumentManagerInterface $documentManager,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @throws PageDocumentNotLoadedException
     */
    #[\Override]
    public function load(DocumentPath $documentPath): BasePageDocument
    {
        try {
            $this->logger->info('Start loading document with path.', [
                'path' => $documentPath->value,
            ]);
            $document = $this->documentManager->find($documentPath->value);
            if (!$document instanceof BasePageDocument) {
                $this->logger->notice('Error by validating loaded object.');
                $this->logger->debug('Error by validating loaded object.', [
                    'className' => $document::class,
                ]);
                throw PageDocumentNotLoadedException::pathIsInvalid($documentPath->value);
            }
            $this->logger->info('Document is successfully loaded.');

            return $document;
        } catch (DocumentManagerException $exception) {
            $this->logger->notice('Error by loading document with path.');
            $this->logger->debug('Error by loading document with path.', [
                'exceptionMessage' => $exception->getMessage(),
            ]);
            throw PageDocumentNotLoadedException::documentNotLoaded($documentPath->value, $exception->getMessage());
        }
    }
}
