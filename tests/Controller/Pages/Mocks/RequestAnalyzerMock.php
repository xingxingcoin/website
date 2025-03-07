<?php
declare(strict_types=1);

namespace App\Tests\Controller\Pages\Mocks;

use DateTime;
use Sulu\Component\Localization\Localization;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;
use Sulu\Component\Webspace\Portal;
use Sulu\Component\Webspace\PortalInformation;
use Sulu\Component\Webspace\Segment;
use Sulu\Component\Webspace\Webspace;
use Symfony\Component\HttpFoundation\Request;

final class RequestAnalyzerMock implements RequestAnalyzerInterface
{
    public Request $inputRequest;
    public int $outputMatchType;
    public DateTime $outputDateTime;
    public Webspace $outputWebspace;
    public Portal $outputPortal;
    public Segment $outputSegment;
    public string $inputSegmentKey;
    public Localization $outputLocalization;
    public string $outputRedirect;
    public string $outputPortalUrl;
    public string $outputResourceLocator;
    public string $outputResourceLocatorPrefix;
    public PortalInformation $outputPortalInformation;
    public string $inputName;
    public mixed $inputDefault;
    public array $outputAttribute;

    public function analyze(Request $request): void
    {
        $this->inputRequest = $request;
    }

    public function validate(Request $request): void
    {
        $this->inputRequest = $request;
    }

    public function getMatchType(): int
    {
        return $this->outputMatchType;
    }

    public function getDateTime(): DateTime
    {
        return $this->outputDateTime;
    }

    public function getWebspace(): Webspace
    {
        return $this->outputWebspace;
    }

    public function getPortal(): Portal
    {
        return $this->outputPortal;
    }

    public function getSegment(): Segment
    {
        return $this->outputSegment;
    }

    public function changeSegment(string $segmentKey): void
    {
        $this->inputSegmentKey = $segmentKey;
    }

    public function getCurrentLocalization(): Localization
    {
        return $this->outputLocalization;
    }

    public function getRedirect(): string
    {
        return $this->outputRedirect;
    }

    public function getPortalUrl(): string
    {
        return $this->outputPortalUrl;
    }

    public function getResourceLocator(): string
    {
        return $this->outputResourceLocator;
    }

    public function getResourceLocatorPrefix(): string
    {
        return $this->outputResourceLocatorPrefix;
    }

    public function getPortalInformation(): PortalInformation
    {
        return $this->outputPortalInformation;
    }

    public function getAttribute($name, $default = null): array
    {
        $this->inputName = $name;
        $this->inputDefault = $default;

        return $this->outputAttribute;
    }
}
