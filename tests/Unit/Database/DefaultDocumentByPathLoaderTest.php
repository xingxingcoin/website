<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database;

use App\Database\DefaultDocumentByPathLoader;
use App\Tests\Unit\Database\Mocks\DocumentManagerMock;
use App\Tests\Unit\Mocks\LoggerMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Sulu\Component\DocumentManager\Exception\DocumentManagerException;
use App\Database\Exception\PageDocumentNotLoadedException;
use App\Database\Model\DocumentPath;

#[CoversClass(DefaultDocumentByPathLoader::class)]
#[UsesClass(DocumentPath::class)]
final class DefaultDocumentByPathLoaderTest extends TestCase
{
    private DocumentManagerMock $documentManagerMock;
    private LoggerMock $loggerMock;
    private DefaultDocumentByPathLoader $defaultDocumentByPathLoader;

    protected function setUp(): void
    {
        $this->documentManagerMock = new DocumentManagerMock();
        $this->loggerMock = new LoggerMock();
        $this->defaultDocumentByPathLoader = new DefaultDocumentByPathLoader(
            $this->documentManagerMock,
            $this->loggerMock
        );
    }

    public function testLoad_is_valid(): void
    {
        $expectedDocumentPath = new DocumentPath('testPath');
        $expectedDocument = new BasePageDocument();
        $this->documentManagerMock->outputFind = $expectedDocument;

        $document = $this->defaultDocumentByPathLoader->load($expectedDocumentPath);

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
            $this->defaultDocumentByPathLoader->load($expectedDocumentPath);
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
            $this->defaultDocumentByPathLoader->load($expectedDocumentPath);
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
