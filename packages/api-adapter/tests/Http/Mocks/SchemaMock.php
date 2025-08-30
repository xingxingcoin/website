<?php

declare(strict_types=1);

namespace XingXingCoin\ApiAdapter\Tests\Http\Mocks;

use Opis\JsonSchema\Errors\ValidationError;
use Opis\JsonSchema\Info\SchemaInfo;
use Opis\JsonSchema\Schema;
use Opis\JsonSchema\ValidationContext;

final class SchemaMock implements Schema
{
    public SchemaInfo $outputSchemaInfo;
    public ValidationContext $inputValidationContext;
    public ?ValidationError $outputValidationError = null;

    public function info(): SchemaInfo
    {
        return $this->outputSchemaInfo;
    }

    public function validate(ValidationContext $context): ?ValidationError
    {
        $this->inputValidationContext = $context;

        return $this->outputValidationError;
    }
}
