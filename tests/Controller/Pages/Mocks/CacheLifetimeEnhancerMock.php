<?php
declare(strict_types=1);

namespace App\Tests\Controller\Pages\Mocks;

use Sulu\Bundle\HttpCacheBundle\CacheLifetime\CacheLifetimeEnhancerInterface;
use Sulu\Component\Content\Compat\StructureInterface;
use Symfony\Component\HttpFoundation\Response;

final class CacheLifetimeEnhancerMock implements CacheLifetimeEnhancerInterface
{
    public Response $inputResponse;
    public StructureInterface $inputStructure;

    public function enhance(Response $response, StructureInterface $structure): void
    {
        $this->inputResponse = $response;
        $this->inputStructure = $structure;
    }
}
