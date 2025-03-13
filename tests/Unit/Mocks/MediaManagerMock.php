<?php

declare(strict_types=1);

namespace App\Tests\Unit\Mocks;

use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Sulu\Bundle\MediaBundle\Media\Exception\MediaNotFoundException;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManagerInterface;

final class MediaManagerMock implements MediaManagerInterface
{
    public ?int $inputId;
    public ?string $inputLocale;
    public Media $outputMedia;
    public ?MediaNotFoundException $throwMediaNotFoundException = null;

    /**
     * @return Media[]
     */
    public function get($locale, $filter = [], $limit = null, $offset = null): array
    {
        // TODO: Implement get() method.
    }

    public function getCount(): int
    {
        // TODO: Implement getCount() method.
    }

    /**
     * @throws MediaNotFoundException
     */
    public function getById($id, $locale): Media
    {
        $this->inputId = $id;
        $this->inputLocale = $locale;
        if ($this->throwMediaNotFoundException instanceof MediaNotFoundException) {
            throw $this->throwMediaNotFoundException;
        }

        return $this->outputMedia;
    }

    public function getEntityById($id): MediaInterface
    {
        // TODO: Implement getEntityById() method.
    }

    /**
     * @return Media[]
     */
    public function getByIds(array $ids, $locale): array
    {
        // TODO: Implement getByIds() method.
    }

    public function save($uploadedFile, $data, $userId): Media
    {
        // TODO: Implement save() method.
    }

    public function delete($id, $checkSecurity = false): void
    {
        // TODO: Implement delete() method.
    }

    public function move($id, $locale, $destCollection): Media
    {
        // TODO: Implement move() method.
    }

    public function increaseDownloadCounter($fileVersionId): void
    {
        // TODO: Implement increaseDownloadCounter() method.
    }

    public function getFormatUrls($ids, $locale): array
    {
        // TODO: Implement getFormatUrls() method.
    }

    public function addFormatsAndUrl(Media $media): Media
    {
        // TODO: Implement addFormatsAndUrl() method.
    }

    public function getUrl($id, $fileName, $version): string
    {
        // TODO: Implement getUrl() method.
    }

    public function removeFileVersion(int $mediaId, int $version): void
    {
        // TODO: Implement removeFileVersion() method.
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method string getAdminUrl($id, $fileName, $version)
    }
}
