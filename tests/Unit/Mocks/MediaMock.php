<?php

declare(strict_types=1);

namespace App\Tests\Unit\Mocks;

use Doctrine\Common\Collections\Collection;
use Sulu\Bundle\MediaBundle\Entity\CollectionInterface;
use Sulu\Bundle\MediaBundle\Entity\File;
use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Sulu\Bundle\MediaBundle\Entity\MediaType;
use Sulu\Component\Security\Authentication\UserInterface;

final class MediaMock implements MediaInterface
{
    public function getId(): int
    {
        // TODO: Implement getId() method.
    }

    public function setCreated($created): MediaInterface
    {
        // TODO: Implement setCreated() method.
    }

    public function setChanged($changed): MediaInterface
    {
        // TODO: Implement setChanged() method.
    }

    public function addFile(File $files): void
    {
        // TODO: Implement addFile() method.
    }

    public function removeFile(File $files): Collection
    {
        // TODO: Implement removeFile() method.
    }

    public function getFiles(): MediaInterface
    {
        // TODO: Implement getFiles() method.
    }

    public function setCollection(CollectionInterface $collection): MediaInterface
    {
        // TODO: Implement setCollection() method.
    }

    public function getCollection(): CollectionInterface
    {
        // TODO: Implement getCollection() method.
    }

    public function setType(MediaType $type): MediaInterface
    {
        // TODO: Implement setType() method.
    }

    public function getType(): MediaType
    {
        // TODO: Implement getType() method.
    }

    public function setChanger($changer): MediaInterface
    {
        // TODO: Implement setChanger() method.
    }

    public function setCreator($creator): MediaInterface
    {
        // TODO: Implement setCreator() method.
    }

    public function setPreviewImage(?MediaInterface $previewImage = null): ?MediaInterface
    {
        // TODO: Implement setPreviewImage() method.
    }

    public function getPreviewImage(): ?MediaInterface
    {
        // TODO: Implement getPreviewImage() method.
    }

    public function getCreated(): \DateTime
    {
        // TODO: Implement getCreated() method.
    }

    public function getChanged(): \DateTime
    {
        // TODO: Implement getChanged() method.
    }

    public function getCreator(): UserInterface
    {
        // TODO: Implement getCreator() method.
    }

    public function getChanger(): UserInterface
    {
        // TODO: Implement getChanger() method.
    }
}
