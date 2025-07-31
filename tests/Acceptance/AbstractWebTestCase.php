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
    public KernelBrowser $client;
    public Media $media;

    protected function setUp(): void
    {
        static::ensureKernelShutdown();
        $this->client = static::createAuthenticatedClient();
        $this->purgeDatabase();
    }

    protected function generateWebsiteHomepageTestDataSet(int $mediaId): void
    {
        $options = [
            'locales' => ['en'],
        ];
        $manager = $this->getDocumentManager();
        /** @var HomeDocument $document */
        $document = $manager->find('/cmf/website/contents', 'en');
        $document->getStructure()->bind([
            'header' => [
                'xing_music' => 'default-audio.mp3'
            ],
            'footer_social_media' => [
                'footer_twitter_logo' => 'test_twitter_logo.png',
                'footer_twitter_link' => 'x.com',
                'footer_dexscreener_logo' => 'test_dexscreener_logo.png',
                'footer_dexscreener_link' => 'dexscreener.com',
                'footer_telegram_logo' => 'test_telegram_logo.png',
                'footer_telegram_link' => 'telegram.com',
                'footer_tiktok_logo' => 'test_tiktok_logo.png',
                'footer_tiktok_link' => 'tiktok.com',
            ],
            'blocks' => [
                [
                    'type' => 'xing_information',
                    'xing_information_image_rage_mode' => [
                        'id' => $mediaId,
                    ],
                    'xing_information_image_upset' => [
                        'id' => $mediaId,
                    ],
                    'xing_information_image_neutral' => [
                        'id' => $mediaId,
                    ],
                    'xing_information_image_calm' => [
                        'id' => $mediaId,
                    ],
                    'xing_information_image_happy' => [
                        'id' => $mediaId,
                    ],
                ],
                [
                    'type' => 'xing_address',
                    'xing_address_text' => '5JcdnWEwuHh1v3SAARq8zH9tEwDQGpaHzBrZ81m4pump',
                ],
            ]
        ]);

        foreach ($options['locales'] as $locale) {
            $manager->persist($document, $locale, [
                'path' => '/cmf/website/contents'
            ]);
            $manager->publish($document, $locale, [
                'path' => '/cmf/website/contents'
            ]);
        }
        $manager->flush();
    }

    protected function generateGalleryDocumentTestDataSet(int $mediaId): void
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
            'header' => [
                'xing_music' => 'default-audio.mp3'
            ],
            'footer_social_media' => [
                'footer_twitter_logo' => 'test_twitter_logo.png',
                'footer_twitter_link' => 'x.com',
                'footer_dexscreener_logo' => 'test_dexscreener_logo.png',
                'footer_dexscreener_link' => 'dexscreener.com',
                'footer_telegram_logo' => 'test_telegram_logo.png',
                'footer_telegram_link' => 'telegram.com',
                'footer_tiktok_logo' => 'test_tiktok_logo.png',
                'footer_tiktok_link' => 'tiktok.com',
            ],
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
                'path' => '/cmf/website/contents/xing-xing-on-camera'
            ]);
            $manager->publish($document, $locale, [
                'path' => '/cmf/website/contents/xing-xing-on-camera'
            ]);
        }

        $manager->flush();

        /** @var HomeDocument $document */
        $document = $manager->create('page');
        $document->setTitle('Test');
        $document->setStructureType('image_viewer');
        $document->setResourceSegment('/xing-xing-on-camera/image-viewer');
        $document->setLocale('en');
        $document->getStructure()->bind([
            'header' => [
                'xing_music' => 'default-audio.mp3'
            ],
            'footer_social_media' => [
                'footer_twitter_logo' => 'test_twitter_logo.png',
                'footer_twitter_link' => 'x.com',
                'footer_dexscreener_logo' => 'test_dexscreener_logo.png',
                'footer_dexscreener_link' => 'dexscreener.com',
                'footer_telegram_logo' => 'test_telegram_logo.png',
                'footer_telegram_link' => 'telegram.com',
                'footer_tiktok_logo' => 'test_tiktok_logo.png',
                'footer_tiktok_link' => 'tiktok.com',
            ],
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

    protected function generateMemeGeneratorDocumentTestDataSet(int $mediaId): void
    {
        $options = [
            'locales' => ['en'],
        ];

        $manager = $this->getDocumentManager();
        /** @var HomeDocument $document */
        $document = $manager->create('page');
        $document->setTitle('Test');
        $document->setStructureType('meme_generator');
        $document->setResourceSegment('/meme-generator');
        $document->setLocale('en');
        $document->getStructure()->bind([
            'header' => [
                'xing_music' => 'default-audio.mp3'
            ],
            'footer_social_media' => [
                'footer_twitter_logo' => 'test_twitter_logo.png',
                'footer_twitter_link' => 'x.com',
                'footer_dexscreener_logo' => 'test_dexscreener_logo.png',
                'footer_dexscreener_link' => 'dexscreener.com',
                'footer_telegram_logo' => 'test_telegram_logo.png',
                'footer_telegram_link' => 'telegram.com',
                'footer_tiktok_logo' => 'test_tiktok_logo.png',
                'footer_tiktok_link' => 'tiktok.com',
            ],
            'blocks' => [
                [
                    'type' => 'xing_meme_generator',
                    'media' => [
                        'ids' => [
                            $mediaId
                        ]
                    ]
                ],
                [
                    'type' => 'xing_meme_generator',
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
                'path' => '/cmf/website/contents/meme-generator'
            ]);
            $manager->publish($document, $locale, [
                'path' => '/cmf/website/contents/meme-generator'
            ]);
        }

        $manager->flush();

        /** @var HomeDocument $document */
        $document = $manager->create('page');
        $document->setTitle('Test');
        $document->setStructureType('new_meme');
        $document->setResourceSegment('/meme-generator/new-meme');
        $document->setLocale('en');
        $document->getStructure()->bind([
            'header' => [
                'xing_music' => 'default-audio.mp3'
            ],
            'footer_social_media' => [
                'footer_twitter_logo' => 'test_twitter_logo.png',
                'footer_twitter_link' => 'x.com',
                'footer_dexscreener_logo' => 'test_dexscreener_logo.png',
                'footer_dexscreener_link' => 'dexscreener.com',
                'footer_telegram_logo' => 'test_telegram_logo.png',
                'footer_telegram_link' => 'telegram.com',
                'footer_tiktok_logo' => 'test_tiktok_logo.png',
                'footer_tiktok_link' => 'tiktok.com',
            ],
        ]);

        foreach ($options['locales'] as $locale) {
            $manager->persist($document, $locale, [
                'path' => '/cmf/website/contents/meme-generator/new-meme'
            ]);
            $manager->publish($document, $locale, [
                'path' => '/cmf/website/contents/meme-generator/new-meme'
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
        $mediaTypes->setName('image');
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
