<?php

declare(strict_types=1);

namespace App\Controller\Pages;

use Sulu\Bundle\HttpCacheBundle\CacheLifetime\CacheLifetimeEnhancerInterface;
use Sulu\Bundle\WebsiteBundle\Resolver\ParameterResolverInterface;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Environment as Twig;

class WebsiteController implements ServiceSubscriberInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private Twig $twig,
        private ParameterResolverInterface $parmeterResolver,
        private RequestAnalyzerInterface $requestAnalyzer,
        private CacheLifetimeEnhancerInterface $cacheLiefetimeEnhancer
    ) {
    }

    protected function render(
        StructureInterface $structure,
        $attributes = []
    ): Response {
        $request = $this->requestStack->getCurrentRequest();
        $viewTemplate = $structure->getView() . '.html.twig';
        if (!$this->twig->getLoader()->exists($viewTemplate)) {
            throw new NotAcceptableHttpException('Page does not exist in "html" format.');
        }

        $data = $this->getAttributes($attributes, $structure);
        $content = $this->twig->render(
            $viewTemplate,
            $data
        );
        $response = new Response($content);
        $mimeType = $request->getMimeType('html');
        if ($mimeType) {
            $response->headers->set('Content-Type', $mimeType);
        }
        $this->cacheLiefetimeEnhancer->enhance($response, $structure);

        return $response;
    }

    protected function getAttributes($attributes, StructureInterface $structure): array
    {
        return $this->parmeterResolver->resolve(
            $attributes,
            $this->requestAnalyzer,
            $structure
        );
    }

    public static function getSubscribedServices(): array
    {
        $subscribedServices['sulu_website.resolver.parameter'] = ParameterResolverInterface::class;
        $subscribedServices['sulu_core.webspace.request_analyzer'] = RequestAnalyzerInterface::class;
        $subscribedServices['sulu_http_cache.cache_lifetime.enhancer'] = '?' . CacheLifetimeEnhancerInterface::class;

        return $subscribedServices;
    }
}
