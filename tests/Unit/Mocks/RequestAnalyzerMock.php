<?php

declare(strict_types=1);

namespace App\Tests\Unit\Mocks;

use Sulu\Component\Localization\Localization;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;
use Sulu\Component\Webspace\Webspace;
use Symfony\Component\HttpFoundation\Request;

final class RequestAnalyzerMock implements RequestAnalyzerInterface
{
    public Webspace $outputWebspace;
    public Localization $outputLocalization;

    public function analyze(Request $request)
    {
        // TODO: Implement analyze() method.
    }

    public function validate(Request $request)
    {
        // TODO: Implement validate() method.
    }

    public function getMatchType()
    {
        // TODO: Implement getMatchType() method.
    }

    public function getDateTime()
    {
        // TODO: Implement getDateTime() method.
    }

    public function getWebspace(): Webspace
    {
        return $this->outputWebspace;
    }

    public function getPortal()
    {
        // TODO: Implement getPortal() method.
    }

    public function getSegment()
    {
        // TODO: Implement getSegment() method.
    }

    public function changeSegment(string $segmentKey)
    {
        // TODO: Implement changeSegment() method.
    }

    public function getCurrentLocalization(): Localization
    {
        return $this->outputLocalization;
    }

    public function getRedirect()
    {
        // TODO: Implement getRedirect() method.
    }

    public function getPortalUrl()
    {
        // TODO: Implement getPortalUrl() method.
    }

    public function getResourceLocator()
    {
        // TODO: Implement getResourceLocator() method.
    }

    public function getResourceLocatorPrefix()
    {
        // TODO: Implement getResourceLocatorPrefix() method.
    }

    public function getPortalInformation()
    {
        // TODO: Implement getPortalInformation() method.
    }

    public function getAttribute($name, $default = null)
    {
        // TODO: Implement getAttribute() method.
    }
}
