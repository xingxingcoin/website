<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use App\Database\Model\DocumentPath;
use App\Exception\EmptyStringException;

#[CoversClass(DocumentPath::class)]
final class DocumentPathTest extends TestCase
{
    public function testDocumentPath_is_valid(): void
    {
        $expectedDocumentPathString = 'testDocumentPath';
        $documentPath = new DocumentPath($expectedDocumentPathString);
        self::assertSame($expectedDocumentPathString, $documentPath->value);
    }

    public function testDocumentPath_with_empty_string(): void
    {
        $expectedDocumentPathString = '';
        try {
            new DocumentPath($expectedDocumentPathString);
        } catch (EmptyStringException $exception) {
            self::assertSame(
                'Validation failed for value "documentPath" with error: "Value for "documentPath" should not be empty."',
                $exception->getMessage()
            );
        }
    }
}
