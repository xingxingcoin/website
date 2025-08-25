<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use Psr\Log\LoggerInterface;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManagerInterface;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\MediaUrlCollectionByDocumentLoader as MediaUrlCollectionByDocumentLoaderInterface;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use XingXingCoin\Core\Gallery\NavigationMediaUrlLoader;
use XingXingCoin\Core\Model\Location;

final readonly class MediaUrlCollectionByDocumentLoader implements MediaUrlCollectionByDocumentLoaderInterface
{
    public function __construct(
        private MediaManagerInterface $mediaManager,
        private NavigationMediaUrlLoader $navigationMediaUrlLoader,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws MediaUrlNotLoadedException
     */
    #[\Override]
    public function load(
        BasePageDocument $document,
        Location $location,
        RootNavigation $rootNavigation,
        SubNavigation $subNavigation
    ): MediaUrlCollection {
        try {
            $this->logger->info('Start loading mediaUrls with mediaIds and location.');
            $mediaUrls = [];
            $mediaNavigationUrl = $this->navigationMediaUrlLoader->load(
                $rootNavigation,
                $subNavigation,
                $location
            );
            foreach ($this->getMediaIds($document) as $mediaId) {
                $media = $this->mediaManager->getById($mediaId, $location->value);
                $mediaUrls[] = [
                    'imageViewerUrl' => $mediaNavigationUrl->value . '?mediaId=' . $mediaId,
                    'mediaUrl' => $media->getUrl()
                ];
            }
            $this->logger->info('MediaUrls are successfully loaded.');

            return new MediaUrlCollection($mediaUrls);
        } catch (\Throwable $exception) {
            $this->logger->notice('Error by loading mediaUrls with mediaIds and location.');
            $this->logger->debug('Error by loading mediaUrls with mediaIds and location.', [
                'exceptionMessage' => $exception->getMessage()
            ]);
            throw MediaUrlNotLoadedException::mediaNotFound($exception->getMessage());
        }
    }

    /**
     * @throws MediaUrlNotLoadedException
     */
    private function getMediaIds(BasePageDocument $document): array
    {
        /** @var array<string, array<string, int>>|null $mediaBlock */
        $mediaBlock = $document->getStructure()->getProperty('blocks')->offsetGet(0) ?? [];
        if (!is_array($mediaBlock) || !array_key_exists('media', $mediaBlock) || !array_key_exists(
                'ids',
                $mediaBlock['media']
            )) {
            throw MediaUrlNotLoadedException::mediaIdNotFound();
        }

        /** @var array<int, int> $mediaIds */
        $mediaIds = $mediaBlock['media']['ids'];

        return $mediaIds;
    }
}
