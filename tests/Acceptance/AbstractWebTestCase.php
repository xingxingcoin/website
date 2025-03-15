<?php

declare(strict_types=1);

namespace App\Tests\Acceptance;

use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Entity\Collection;
use Sulu\Bundle\MediaBundle\Entity\CollectionType;
use Sulu\Bundle\MediaBundle\Entity\MediaType;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManagerInterface;
use Sulu\Bundle\PageBundle\Document\HomeDocument;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Sulu\Component\DocumentManager\DocumentManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class AbstractWebTestCase extends SuluTestCase
{
    private const string BASE_PATH = '/cmf/website/contents/xing-xing-on-camera';

    public KernelBrowser $client;
    public Media $media;

    protected function setUp(): void
    {
        static::ensureKernelShutdown();
        $this->client = static::createAuthenticatedClient();
        $this->purgeDatabase();
    }

    protected function generateDocumentTestDataSet(int $mediaId): void
    {
        $options = [
            'locales' => ['en'],
        ];

        $manager = $this->getDocumentManager();
        /** @var HomeDocument $document */
        $document = $manager->create('page');
        $document->setTitle('Test');
        $document->setStructureType('gallery');
        $document->setResourceSegment('/xing-xing-on-camera');
        $document->setLocale('en');
        $document->getStructure()->bind([
            'xing_header_audio' => 'default-audio.mp3',
            'twitter_logo' => 'test_twitter_logo.png',
            'dexscreener_logo' => 'test_dexscreener_logo.png',
            'telegram_logo' => 'test_telegram_logo.png',
            'tiktok_logo' => 'test_tiktok_logo.png',
            'blocks' => [
                [
                    'type' => 'xing_media',
                    'media' => [
                        'ids' => [
                            $mediaId
                        ]
                    ]
                ],
                [
                    'type' => 'xing_media',
                    'media' => [
                        'ids' => [
                            $mediaId
                        ]
                    ]
                ]
            ]
        ]);

        foreach ($options['locales'] as $locale) {
            $manager->persist($document, $locale, [
                'path' => self::BASE_PATH
            ]);
            $manager->publish($document, $locale, [
                'path' => self::BASE_PATH
            ]);
        }

        $manager->flush();

        /** @var HomeDocument $document */
        $document = $manager->create('page');
        $document->setTitle('Test');
        $document->setStructureType('image_viewer');
        $document->setResourceSegment('/xing-xing-on-camera/image_viewer');
        $document->setLocale('en');
        $document->getStructure()->bind([
            'xing_header_audio' => 'default-audio.mp3',
            'twitter_logo' => 'test_twitter_logo.png',
            'dexscreener_logo' => 'test_dexscreener_logo.png',
            'telegram_logo' => 'test_telegram_logo.png',
            'tiktok_logo' => 'test_tiktok_logo.png'
        ]);

        foreach ($options['locales'] as $locale) {
            $manager->persist($document, $locale, [
                'path' => '/cmf/website/contents/xing-xing-on-camera/image-viewer'
            ]);
            $manager->publish($document, $locale, [
                'path' => '/cmf/website/contents/xing-xing-on-camera/image-viewer'
            ]);
        }

        $manager->flush();
    }

    protected function generateMediaTestDataSet(): void
    {
        $mediaManager = $this->getMediaManager();

        $collectionTypes = new CollectionType();
        $collectionTypes->setName('test');
        $this->getEntityManager()->persist($collectionTypes);
        $this->getEntityManager()->flush();

        $collection = new Collection();
        $collection->setType($collectionTypes);
        $collection->setType($collectionTypes);
        $this->getEntityManager()->persist($collection);
        $this->getEntityManager()->flush();

        $uploadedFile = new UploadedFile(
            __DIR__ . '/test-image.jpg',
            'test-image.jpg',
            'image/jpeg',
            null,
            true
        );

        $mediaTypes = new MediaType();
        $mediaTypes->setName('document');
        $this->getEntityManager()->persist($mediaTypes);
        $this->getEntityManager()->flush();
        $this->media = $mediaManager->save($uploadedFile, [
            'id' => null,
            'type' => 'image',
            'collection' => $collection->getId(),
            'locale' => 'en',
            'title' => 'Test Image',
            'description' => 'Test image description'
        ], 'en');
    }

    private function getDocumentManager(): DocumentManagerInterface
    {
        return $this->getContainer()->get('sulu_document_manager.document_manager');
    }

    private function getMediaManager(): MediaManagerInterface
    {
        return $this->getContainer()->get('sulu_media.media_manager');
    }
}
