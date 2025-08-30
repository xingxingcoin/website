<?php

declare(strict_types=1);

namespace App\Tests\Unit\Database\Model;

use App\Database\Model\DocumentPath;
use App\Exception\EmptyStringException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DocumentPath::class)]
final class DocumentPathTest extends TestCase
{
    public function testDocumentPathIsValid(): void
    {
        $expectedDocumentPathString = 'testDocumentPath';
        $documentPath = new DocumentPath($expectedDocumentPathString);
        self::assertSame($expectedDocumentPathString, $documentPath->value);
    }

    public function testDocumentPathWithEmptyString(): void
    {
        $expectedDocumentPathString = '';
        try {
            new DocumentPath($expectedDocumentPathString);
        } catch (EmptyStringException $exception) {
            self::assertSame(
                'Validation failed for value "documentPath" with error: "Value for "documentPath" should not be empty."',
                $exception->getMessage(),
            );
        }
    }
}
