<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use App\Database\Exception\MediaNotFoundException;
use App\Database\MediaByMediaIdLoader;
use App\Database\Model\MediaId;
use App\Database\NavigationUrlLoader;
use XingXingCoin\Core\Exception\EmptyStringException;
use XingXingCoin\Core\Gallery\Exception\MediaUrlNotLoadedException;
use XingXingCoin\Core\Gallery\MediaUrlCollectionByDocumentLoader as MediaUrlCollectionByDocumentLoaderInterface;
use XingXingCoin\Core\Gallery\Model\MediaUrlCollection;
use XingXingCoin\Core\Gallery\Model\RootNavigation;
use XingXingCoin\Core\Gallery\Model\SubNavigation;
use XingXingCoin\Core\Model\Location;

final readonly class MediaUrlCollectionByDocumentLoader implements MediaUrlCollectionByDocumentLoaderInterface
{
    public function __construct(
        private MediaByMediaIdLoader $mediaByMediaIdLoader,
        private NavigationUrlLoader $navigationUrlLoader
    ) {
    }

    /**
     * @throws MediaUrlNotLoadedException
     * @throws MediaNotFoundException
     * @throws EmptyStringException
     */
    #[\Override]
    public function load(
        BasePageDocument $document,
        Location $location,
        RootNavigation $rootNavigation,
        SubNavigation $subNavigation
    ): MediaUrlCollection {
        $mediaUrls = [];
        $mediaNavigationUrl = $this->navigationUrlLoader->load(
            $rootNavigation,
            $subNavigation,
            $location
        );
        foreach ($this->getMediaIds($document) as $mediaId) {
            $media = $this->mediaByMediaIdLoader->load(new MediaId($mediaId), $location);
            $mediaUrls[] = [
                'imageViewerUrl' => $mediaNavigationUrl->value . '?mediaId=' . $mediaId,
                'mediaUrl' => $media->getUrl()
            ];
        }

        return new MediaUrlCollection($mediaUrls);
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
