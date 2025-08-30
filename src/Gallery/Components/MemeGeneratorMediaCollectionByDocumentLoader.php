<?php

declare(strict_types=1);

namespace App\Gallery\Components;

use App\Database\Exception\MediaNotFoundException;
use App\Database\MediaByMediaIdLoader;
use App\Database\Model\Location;
use App\Database\Model\MediaId;
use App\Database\Model\RootNavigation;
use App\Database\Model\SubNavigation;
use App\Database\NavigationUrlLoader;
use App\Exception\EmptyStringException;
use Sulu\Bundle\PageBundle\Document\BasePageDocument;
use XingXingCoin\Core\Gallery\Exception\MediaDataNotLoadedException;
use XingXingCoin\Core\Gallery\MediaCollectionByDocumentLoader;
use XingXingCoin\Core\Gallery\Model\MediaCollection;

final readonly class MemeGeneratorMediaCollectionByDocumentLoader implements MediaCollectionByDocumentLoader
{
    public const string IMAGE_VIEWER_URL_KEY = 'imageViewerUrl';
    public const string MEDIA_URL_KEY = 'mediaUrl';
    public const string MEDIA_NAME_KEY = 'mediaName';

    public function __construct(
        private MediaByMediaIdLoader $mediaByMediaIdLoader,
        private NavigationUrlLoader $navigationUrlLoader,
    ) {
    }

    /**
     * @throws MediaDataNotLoadedException
     * @throws MediaNotFoundException
     * @throws EmptyStringException
     */
    #[\Override]
    public function load(
        BasePageDocument $document,
        Location $location,
        RootNavigation $rootNavigation,
        SubNavigation $subNavigation,
    ): MediaCollection {
        $mediaData = [];
        $mediaNavigationUrl = $this->navigationUrlLoader->load(
            $rootNavigation,
            $subNavigation,
            $location,
        );
        foreach ($this->getMediaIds($document) as $mediaId) {
            $media = $this->mediaByMediaIdLoader->load(new MediaId($mediaId), $location);
            $mediaData[] = [
                self::IMAGE_VIEWER_URL_KEY => $mediaNavigationUrl->value . '?mediaId=' . $mediaId,
                self::MEDIA_URL_KEY => $media->getUrl(),
                self::MEDIA_NAME_KEY => $media->getName(),
            ];
        }

        return new MediaCollection($mediaData);
    }

    /**
     * @throws MediaDataNotLoadedException
     */
    private function getMediaIds(BasePageDocument $document): array
    {
        /** @var array<string, array<string, int>>|null $mediaBlock */
        $mediaBlock = $document->getStructure()->getProperty('blocks')->offsetGet(0) ?? [];
        if (!\is_array($mediaBlock) || !\array_key_exists('media', $mediaBlock) || !\array_key_exists(
            'ids',
            $mediaBlock['media'],
        )) {
            throw MediaDataNotLoadedException::mediaIdNotFound();
        }

        /** @var array<int, int> $mediaIds */
        $mediaIds = $mediaBlock['media']['ids'];

        return $mediaIds;
    }
}
