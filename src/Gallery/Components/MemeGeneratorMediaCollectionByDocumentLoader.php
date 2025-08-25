<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use App\Gallery\Exception\MediaDataNotLoadedException;
use App\Gallery\Model\MediaCollection;
use App\Gallery\Model\RootNavigation;
use App\Gallery\Model\SubNavigation;
use Psr\Log\LoggerInterface;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManagerInterface;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use Xingxingcoin\Core\Gallery\MediaCollectionByDocumentLoader;
use Xingxingcoin\Core\Gallery\NavigationMediaUrlLoader;
use Xingxingcoin\Core\Model\Location;

final readonly class MemeGeneratorMediaCollectionByDocumentLoader implements MediaCollectionByDocumentLoader
{
    public const string IMAGE_VIEWER_URL_KEY = 'imageViewerUrl';
    public const string MEDIA_URL_KEY = 'mediaUrl';
    public const string MEDIA_NAME_KEY = 'mediaName';

    public function __construct(
        private MediaManagerInterface $mediaManager,
        private NavigationMediaUrlLoader $navigationMediaUrlLoader,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws MediaDataNotLoadedException
     */
    #[\Override]
    public function load(
        BasePageDocument $document,
        Location $location,
        RootNavigation $rootNavigation,
        SubNavigation $subNavigation
    ): MediaCollection {
        try {
            $this->logger->info('Start loading media data with mediaIds and location.');
            $mediaData = [];
            $mediaNavigationUrl = $this->navigationMediaUrlLoader->load(
                $rootNavigation,
                $subNavigation,
                $location
            );
            foreach ($this->getMediaIds($document) as $mediaId) {
                $media = $this->mediaManager->getById($mediaId, $location->value);
                $mediaData[] = [
                    self::IMAGE_VIEWER_URL_KEY => $mediaNavigationUrl->value . '?mediaId=' . $mediaId,
                    self::MEDIA_URL_KEY => $media->getUrl(),
                    self::MEDIA_NAME_KEY => $media->getName()
                ];
            }
            $this->logger->info('Media data are successfully loaded.');

            return new MediaCollection($mediaData);
        } catch (\Throwable $exception) {
            $this->logger->notice('Error by loading media data with mediaIds and location.');
            $this->logger->debug('Error by loading media data with mediaIds and location.', [
                'exceptionMessage' => $exception->getMessage()
            ]);
            throw MediaDataNotLoadedException::mediaNotFound($exception->getMessage());
        }
    }

    /**
     * @throws MediaDataNotLoadedException
     */
    private function getMediaIds(BasePageDocument $document): array
    {
        /** @var array<string, array<string, int>>|null $mediaBlock */
        $mediaBlock = $document->getStructure()->getProperty('blocks')->offsetGet(0) ?? [];
        if (!is_array($mediaBlock) || !array_key_exists('media', $mediaBlock) || !array_key_exists(
                'ids',
                $mediaBlock['media']
            )) {
            throw MediaDataNotLoadedException::mediaIdNotFound();
        }

        /** @var array<int, int> $mediaIds */
        $mediaIds = $mediaBlock['media']['ids'];

        return $mediaIds;
    }
}
