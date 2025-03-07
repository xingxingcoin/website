<?php

declare(strict_types=1);

namespace App\Controller\Pages;

use Sulu\Bundle\HttpCacheBundle\CacheLifetime\CacheLifetimeEnhancerInterface;
use Sulu\Bundle\PreviewBundle\Preview\Preview;
use Sulu\Bundle\WebsiteBundle\Resolver\ParameterResolverInterface;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Environment as Twig;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 * @psalm-suppress all
 */
class WebsiteController implements ServiceSubscriberInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly Twig $twig,
        private readonly ParameterResolverInterface $parameterResolver,
        private readonly RequestAnalyzerInterface $requestAnalyzer,
        private readonly CacheLifetimeEnhancerInterface $cacheLifetimeEnhancer
    ) {}

    protected function renderStructure(
        StructureInterface $structure,
        $attributes = [],
        $preview = false,
        $partial = false
    ): Response {
        $request = $this->requestStack->getCurrentRequest();
        if (!$preview) {
            $requestFormat = $request->getRequestFormat();
        } else {
            $requestFormat = 'html';
        }

        $viewTemplate = $structure->getView() . '.' . $requestFormat . '.twig';
        if (!$this->twig->getLoader()->exists($viewTemplate)) {
            throw new NotAcceptableHttpException(\sprintf('Page does not exist in "%s" format.', $requestFormat));
        }
        $data = $this->getAttributes($attributes, $structure, $preview);
        if ($partial) {
            $content = $this->renderBlockView(
                $viewTemplate,
                'content',
                $data
            );
        } elseif ($preview) {
            $content = $this->renderPreview(
                $viewTemplate,
                $data
            );
        } else {
            $content = $this->twig->render(
                $viewTemplate,
                $data
            );
        }

        $response = new Response($content);
        $mimeType = $request->getMimeType($requestFormat);
        if ($mimeType) {
            $response->headers->set('Content-Type', $mimeType);
        }
        if (!$preview && $this->cacheLifetimeEnhancer) {
            $this->cacheLifetimeEnhancer->enhance($response, $structure);
        }

        return $response;
    }

    protected function renderPreview(string $view, array $parameters = []): string
    {
        $parameters['previewParentTemplate'] = $view;
        $parameters['previewContentReplacer'] = Preview::CONTENT_REPLACER;

        return $this->twig->render('@SuluWebsite/Preview/preview.html.twig', $parameters);
    }

    protected function renderBlockView($view, $block, $parameters = []): string
    {
        $parameters = $this->twig->mergeGlobals($parameters);

        $template = $this->twig->load($view);

        $level = \ob_get_level();
        \ob_start();

        try {
            $rendered = $template->renderBlock($block, $parameters);
            \ob_end_clean();

            return $rendered;
        } catch (\Exception $exception) {
            while (\ob_get_level() > $level) {
                \ob_end_clean();
            }

            throw $exception;
        }
    }


    protected function getAttributes(array $attributes, ?StructureInterface $structure = null, bool $preview = false): array
    {
        return $this->parameterResolver->resolve(
            $attributes,
            $this->requestAnalyzer,
            $structure,
            $preview
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
