<?php declare(strict_types=1);

namespace App\Controller\Pages;

use App\Finance\XingFinanceDataByDexScreenerApiHandler;
use Sulu\Bundle\HttpCacheBundle\CacheLifetime\CacheLifetimeEnhancerInterface;
use Sulu\Bundle\WebsiteBundle\Resolver\ParameterResolverInterface;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment as Twig;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final class ExtendHomePageByXingDataController extends HomeController
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly Twig $twig,
        private readonly ParameterResolverInterface $parameterResolver,
        private readonly RequestAnalyzerInterface $requestAnalyzer,
        private readonly CacheLifetimeEnhancerInterface $cacheLifetimeEnhancer,
        private readonly XingFinanceDataByDexScreenerApiHandler $xingFinanceDataHandler,
    ){
        parent::__construct(
            $this->requestStack,
            $this->twig,
            $this->parameterResolver,
            $this->requestAnalyzer,
            $this->cacheLifetimeEnhancer
        );
    }

    #[\Override]
    protected function getAttributes(array $attributes, ?StructureInterface $structure = null, bool $preview = false): array
    {
        $attributes = parent::getAttributes($attributes, $structure);
        $attributes['xing']['finance'] = $this->xingFinanceDataHandler->handleAndGet()->data;

        return $attributes;
    }
}
