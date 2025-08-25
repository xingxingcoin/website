<?php

declare(strict_types=1);

namespace App\Finance\Components;

use Psr\Log\LoggerInterface;
use Sulu\Bundle\MediaBundle\Media\Exception\MediaNotFoundException;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManagerInterface;
use Sulu\Component\DocumentManager\PathBuilder;
use Xingxingcoin\ApiAdapter\Finance\Model\FinanceDataCollection;
use Xingxingcoin\Core\Database\DocumentByPathLoader;
use Xingxingcoin\Core\Database\Exception\PageDocumentNotLoadedException;
use Xingxingcoin\Core\Finance\Exception\XingGifNotFoundException;
use Xingxingcoin\Core\Finance\XingGifUrlLoader;
use Xingxingcoin\Core\Model\Location;

final readonly class XingHappyModeGifUrlLoader implements XingGifUrlLoader
{
    public const string MEDIA_IMAGE_KEY = 'xing_information_image_happy';

    public function __construct(
        private PathBuilder $pathBuilder,
        private DocumentByPathLoader $documentByPathLoader,
        private MediaManagerInterface $mediaManager,
        private LoggerInterface $logger
    ) {}


    /**
     * @throws PageDocumentNotLoadedException
     * @throws XingGifNotFoundException
     */
    #[\Override]
    public function load(FinanceDataCollection $financeDataCollection, Location $location): FinanceDataCollection
    {
        try {
            $this->logger->info('Start loading xing happy mode gif url.');
            $path = $this->pathBuilder->build(['%base%', 'website', '%content%']);
            $document = $this->documentByPathLoader->load($path);
            $blocks = $document->getStructure()->getProperty('blocks')->offsetGet(0);
            $mediaId = $blocks[self::MEDIA_IMAGE_KEY]['id'];
            $media = $this->mediaManager->getById($mediaId, $location->value);
            $financeData = array_merge($financeDataCollection->data, ['url' => $media->getFormats()['sulu-400x400']]);
            $this->logger->info('Xing happy mode gif url is loaded successfully.', [
                'mediaId' => $mediaId,
                'url' => $media->getFormats()['sulu-400x400']
            ]);
        } catch (MediaNotFoundException $exception) {
            $this->logger->notice('Xing happy mode gif url is not loaded.');
            $this->logger->debug('Xing happy mode gif url is not loaded.', [
                'exceptionMessage' => $exception->getMessage()
            ]);

            throw XingGifNotFoundException::gifNotFound($exception->getMessage());
        }

        return new FinanceDataCollection($financeData);
    }
}
