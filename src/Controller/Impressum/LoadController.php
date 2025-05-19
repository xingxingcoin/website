<?php

declare(strict_types=1);

namespace App\Controller\Impressum;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final readonly class LoadController
{
    public function __construct(
        private Twig $twig,
    ) {}

    public function __invoke(): Response
    {
        return new Response($this->twig->render('impressum/index.html.twig'));
    }
}
