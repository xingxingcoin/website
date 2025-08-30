<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Pages\Mocks;

use Sulu\Bundle\WebsiteBundle\Resolver\ParameterResolverInterface;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;

final class ParameterResolverMock implements ParameterResolverInterface
{
    public array $inputParameter;
    public ?RequestAnalyzerInterface $inputRequestAnalyzer;
    public ?StructureInterface $inputStructure;
    public bool $inputPreview;
    public array $outputParameterResolve;

    public function resolve(
        array $parameter,
        ?RequestAnalyzerInterface $requestAnalyzer = null,
        ?StructureInterface $structure = null,
        $preview = false,
    ): array {
        $this->inputParameter = $parameter;
        $this->inputRequestAnalyzer = $requestAnalyzer;
        $this->inputStructure = $structure;
        $this->inputPreview = $preview;

        return $this->outputParameterResolve;
    }
}
