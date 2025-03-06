<?php declare(strict_types=1);

namespace App\Controller\Pages;

use App\Finance\XingFinanceDataByDexScreenerApiHandler;
use Sulu\Bundle\HttpCacheBundle\CacheLifetime\CacheLifetimeEnhancerInterface;
use Sulu\Bundle\WebsiteBundle\Resolver\ParameterResolverInterface;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment as Twig;

final class ExtendHomePageByXingDataController extends HomeController
{
    public function __construct(
        private RequestStack $requestStack,
        private Twig $twig,
        private ParameterResolverInterface $parmeterResolver,
        private RequestAnalyzerInterface $requestAnalyzer,
        private CacheLifetimeEnhancerInterface $cacheLiefetimeEnhancer,
        private readonly XingFinanceDataByDexScreenerApiHandler $xingFinanceDataHandler,
    ){
        parent::__construct(
            $this->requestStack,
            $this->twig,
            $this->parmeterResolver,
            $this->requestAnalyzer,
            $this->cacheLiefetimeEnhancer
        );
    }

    protected function getAttributes($attributes, StructureInterface $structure): array
    {
        $attributes = parent::getAttributes($attributes, $structure);
        $attributes['xing']['finance'] = $this->xingFinanceDataHandler->handleAndGet()->data;

        return $attributes;
    }
}
