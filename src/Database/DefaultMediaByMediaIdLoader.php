<?php

declare(strict_types=1);

namespace App\Database;

use Psr\Log\LoggerInterface;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Media\Exception\MediaNotFoundException;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManagerInterface;
use App\Database\Exception\MediaNotFoundException as MediaByMediaIdNotFoundException;
use App\Database\Model\MediaId;
use XingXingCoin\Core\Model\Location;

final readonly class DefaultMediaByMediaIdLoader implements MediaByMediaIdLoader
{
    public function __construct(
        private MediaManagerInterface $mediaManager,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws MediaByMediaIdNotFoundException
     */
    #[\Override]
    public function load(MediaId $mediaId, Location $location): Media
    {
        try {
            $this->logger->info('Start loading media with mediaId and location.');
            $this->logger->debug('Start loading media with mediaId and location.', [
                'mediaId' => $mediaId->value,
                'location' => $location->value
            ]);
            $media = $this->mediaManager->getById($mediaId->value, $location->value);
            $this->logger->info('Media by mediaId and location is successfully loaded.');

            return $media;
        } catch (MediaNotFoundException $exception) {
            $this->logger->notice('Error by loading media with mediaId and location.');
            $this->logger->debug('Error by loading media with mediaId and location.', [
                'exceptionMessage' => $exception->getMessage()
            ]);

            throw MediaByMediaIdNotFoundException::mediaIsInvalid((string)$mediaId->value);
        }
    }
}
