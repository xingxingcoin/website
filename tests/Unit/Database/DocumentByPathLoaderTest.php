<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database;

use App\Database\DocumentByPathLoader;
use App\Tests\Unit\Database\Mocks\DocumentManagerMock;
use App\Tests\Unit\Mocks\LoggerMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\DocumentManager\Exception\DocumentManagerException;
use XingXingCoin\Core\Database\Exception\PageDocumentNotLoadedException;
use XingXingCoin\Core\Database\Model\DocumentPath;

#[CoversClass(DocumentByPathLoader::class)]
#[CoversClass(DocumentPath::class)]
final class DocumentByPathLoaderTest extends TestCase
{
    private DocumentManagerMock $documentManagerMock;
    private LoggerMock $loggerMock;
    private DocumentByPathLoader $documentByPathLoader;

    protected function setUp(): void
    {
        $this->documentManagerMock = new DocumentManagerMock();
        $this->loggerMock = new LoggerMock();
        $this->documentByPathLoader = new DocumentByPathLoader(
            $this->documentManagerMock,
            $this->loggerMock
        );
    }

    public function testLoad_is_valid(): void
    {
        $expectedDocumentPath = new DocumentPath('testPath');
        $expectedDocument = new BasePageDocument();
        $this->documentManagerMock->outputFind = $expectedDocument;

        $document = $this->documentByPathLoader->load($expectedDocumentPath);

        self::assertEquals($expectedDocument, $document);
        self::assertSame($expectedDocumentPath->value, $this->documentManagerMock->inputIdentifier);
        self::assertNull($this->documentManagerMock->inputLocale);
        self::assertEmpty($this->documentManagerMock->inputOptions);
        self::assertEquals([
            'info' => [
                [
                    'message' => 'Start loading document with path.',
                     'context' => [
                         'path' => 'testPath'
                     ]
                ],
                [
                    'message' => 'Document is successfully loaded.',
                    'context' => []
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoad_with_invalid_object_found(): void
    {
        $expectedDocumentPath = new DocumentPath('testPath');
        $expectedDocument = new LoggerMock();
        $this->documentManagerMock->outputFind = $expectedDocument;

        try {
            $this->documentByPathLoader->load($expectedDocumentPath);
            $this->fail('PageDocumentNotLoadedException was expected to be thrown.');
        } catch (PageDocumentNotLoadedException $exception) {
            self::assertSame('Path "testPath" for gallery is invalid.', $exception->getMessage());
        }

        self::assertSame($expectedDocumentPath->value, $this->documentManagerMock->inputIdentifier);
        self::assertNull($this->documentManagerMock->inputLocale);
        self::assertEmpty($this->documentManagerMock->inputOptions);
        self::assertEquals([
            'info' => [
                [
                    'message' => 'Start loading document with path.',
                    'context' => [
                        'path' => 'testPath'
                    ]
                ]
            ],
            'notice' => [
                [
                    'message' => 'Error by validating loaded object.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Error by validating loaded object.',
                    'context' => [
                        'className' => 'App\Tests\Unit\Mocks\LoggerMock'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }

    public function testLoad_with_document_manager_exception(): void
    {
        $expectedDocumentPath = new DocumentPath('testPath');
        $this->documentManagerMock->throwDocumentManagerException = new DocumentManagerException('test');

        try {
            $this->documentByPathLoader->load($expectedDocumentPath);
            $this->fail('PageDocumentNotLoadedException was expected to be thrown.');
        } catch (PageDocumentNotLoadedException $exception) {
            self::assertSame('Document with path "testPath" could not be loaded with error: "test"', $exception->getMessage());
        }

        self::assertSame($expectedDocumentPath->value, $this->documentManagerMock->inputIdentifier);
        self::assertNull($this->documentManagerMock->inputLocale);
        self::assertEmpty($this->documentManagerMock->inputOptions);
        self::assertEquals([
            'info' => [
                [
                    'message' => 'Start loading document with path.',
                    'context' => [
                        'path' => 'testPath'
                    ]
                ]
            ],
            'notice' => [
                [
                    'message' => 'Error by loading document with path.',
                    'context' => []
                ]
            ],
            'debug' => [
                [
                    'message' => 'Error by loading document with path.',
                    'context' => [
                        'exceptionMessage' => 'test'
                    ]
                ]
            ]
        ], $this->loggerMock->logs);
    }
}
