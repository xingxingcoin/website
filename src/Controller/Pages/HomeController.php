<?php
declare(strict_types=1);

namespace App\Controller\Pages;

use Sulu\Component\Content\Compat\StructureInterface;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends WebsiteController
{
    public function indexAction(StructureInterface $structure, $preview = false, $partial = false): Response
    {
        return $this->renderStructure(
            $structure,
            [],
            $preview,
            $partial
        );
    }
}
