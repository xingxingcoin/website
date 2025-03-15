<?php

declare(strict_types=1);

namespace App\Tests\Unit\Mocks;

use Sulu\Bundle\WebsiteBundle\Navigation\NavigationMapperInterface;

final class NavigationMapperMock implements NavigationMapperInterface
{
    public string $inputNavigationParent;
    public string $inputNavigationWebspaceKey;
    public string $inputNavigationLocale;
    public int $inputNavigationDepth;
    public bool $inputNavigationFlat;
    public ?string $inputNavigationContext;
    public bool $inputNavigationLoadExcerpt;
    public array $outputNavigationSubNavigation;
    public mixed $inputNavigationSegmentKey;
    public string $inputNavigationRootWebspaceKey;
    public string $inputNavigationRootLocale;
    public int $inputNavigationRootDepth;
    public bool $inputNavigationRootFlat;
    public ?string $inputNavigationRootContext;
    public bool $inputNavigationRootLoadExcerpt;
    public array $outputNavigationRootRootNavigation;
    public mixed $inputNavigationRootSegmentKey;

    public function getNavigation(
        $parent,
        $webspaceKey,
        $locale,
        $depth = 1,
        $flat = false,
        $context = null,
        $loadExcerpt = false,
        $segmentKey = null
    ): array {
        $this->inputNavigationParent = $parent;
        $this->inputNavigationWebspaceKey = $webspaceKey;
        $this->inputNavigationLocale = $locale;
        $this->inputNavigationDepth = $depth;
        $this->inputNavigationFlat = $flat;
        $this->inputNavigationContext = $context;
        $this->inputNavigationLoadExcerpt = $loadExcerpt;
        $this->inputNavigationSegmentKey = $segmentKey;

        return $this->outputNavigationSubNavigation;
    }

    public function getRootNavigation(
        $webspaceKey,
        $locale,
        $depth = 1,
        $flat = false,
        $context = null,
        $loadExcerpt = false,
        $segmentKey = null
    ): array {
        $this->inputNavigationRootWebspaceKey = $webspaceKey;
        $this->inputNavigationRootLocale = $locale;
        $this->inputNavigationRootDepth = $depth;
        $this->inputNavigationRootFlat = $flat;
        $this->inputNavigationRootContext = $context;
        $this->inputNavigationRootLoadExcerpt = $loadExcerpt;
        $this->inputNavigationRootSegmentKey = $segmentKey;

        return $this->outputNavigationRootRootNavigation;
    }

    public function getBreadcrumb($uuid, $webspace, $language)
    {
        // TODO: Implement getBreadcrumb() method.
    }
}
