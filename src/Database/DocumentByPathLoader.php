<?php

declare(strict_types=1);

namespace App\Database;

use Psr\Log\LoggerInterface;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\DocumentManager\DocumentManagerInterface;
use Sulu\Component\DocumentManager\Exception\DocumentManagerException;
use Xingxingcoin\Core\Database\DocumentByPathLoader;
use Xingxingcoin\Core\Database\Exception\PageDocumentNotLoadedException;

final readonly class DocumentByPathLoader implements DocumentByPathLoader
{
    public function __construct(
        private DocumentManagerInterface $documentManager,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws PageDocumentNotLoadedException
     */
    #[\Override]
    public function load(string $path): BasePageDocument
    {
        try {
            $this->logger->info('Start loading document with path.', [
                'path' => $path
            ]);
            $document = $this->documentManager->find($path);
            if (!$document instanceof BasePageDocument) {
                $this->logger->notice('Error by validating loaded object.');
                $this->logger->debug('Error by validating loaded object.', [
                    'className' => get_class($document)
                ]);
                throw PageDocumentNotLoadedException::pathIsInvalid($path);
            }
            $this->logger->info('Document is successfully loaded.');

            return $document;
        } catch (DocumentManagerException $exception) {
            $this->logger->notice('Error by loading document with path.');
            $this->logger->debug('Error by loading document with path.', [
                'exceptionMessage' => $exception->getMessage()
            ]);
            throw PageDocumentNotLoadedException::documentNotLoaded($path, $exception->getMessage());
        }
    }
}
