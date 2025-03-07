<?php
declare(strict_types=1);

namespace App\Controller\Pages;

use Sulu\Component\Content\Compat\StructureInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
class HomeController extends WebsiteController
{
    public function indexAction(StructureInterface $structure, bool $preview = false, bool $partial = false): Response
    {
        return $this->renderStructure(
            $structure,
            [],
            $preview,
            $partial
        );
    }
}
