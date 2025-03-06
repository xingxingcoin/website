<?php
declare(strict_types=1);

namespace App\Controller\Pages;

use Sulu\Component\Content\Compat\StructureInterface;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends WebsiteController
{
    public function indexAction(StructureInterface $structure): Response
    {
        return $this->render($structure);
    }
}
