<?php

declare(strict_types=1);

namespace App\Tests\Unit\Mocks;

use Sulu\Component\Content\Compat\StructureInterface;

final class StructureMock implements StructureInterface
{
    public string $outputView;

    public function setLanguageCode($language)
    {
        // TODO: Implement setLanguageCode() method.
    }

    public function getLanguageCode()
    {
        // TODO: Implement getLanguageCode() method.
    }

    public function setWebspaceKey($webspace)
    {
        // TODO: Implement setWebspaceKey() method.
    }

    public function getWebspaceKey()
    {
        // TODO: Implement getWebspaceKey() method.
    }

    public function getUuid()
    {
        // TODO: Implement getUuid() method.
    }

    public function setUuid($uuid)
    {
        // TODO: Implement setUuid() method.
    }

    public function getCreator()
    {
        // TODO: Implement getCreator() method.
    }

    public function setCreator($userId)
    {
        // TODO: Implement setCreator() method.
    }

    public function getChanger()
    {
        // TODO: Implement getChanger() method.
    }

    public function setChanger($userId)
    {
        // TODO: Implement setChanger() method.
    }

    public function getCreated()
    {
        // TODO: Implement getCreated() method.
    }

    public function setCreated(\DateTime $created)
    {
        // TODO: Implement setCreated() method.
    }

    public function getChanged()
    {
        // TODO: Implement getChanged() method.
    }

    public function setChanged(\DateTime $changed)
    {
        // TODO: Implement setChanged() method.
    }

    public function getKey()
    {
        // TODO: Implement getKey() method.
    }

    public function getProperty($name)
    {
        // TODO: Implement getProperty() method.
    }

    public function hasProperty($name)
    {
        // TODO: Implement hasProperty() method.
    }

    public function getProperties($flatten = false)
    {
        // TODO: Implement getProperties() method.
    }

    public function setHasChildren($hasChildren)
    {
        // TODO: Implement setHasChildren() method.
    }

    public function getHasChildren()
    {
        // TODO: Implement getHasChildren() method.
    }

    public function setChildren($children)
    {
        // TODO: Implement setChildren() method.
    }

    public function getChildren()
    {
        // TODO: Implement getChildren() method.
    }

    public function getPublishedState()
    {
        // TODO: Implement getPublishedState() method.
    }

    public function setPublished($published)
    {
        // TODO: Implement setPublished() method.
    }

    public function getPublished()
    {
        // TODO: Implement getPublished() method.
    }

    public function getPropertyValue($name)
    {
        // TODO: Implement getPropertyValue() method.
    }

    public function getPropertyNames()
    {
        // TODO: Implement getPropertyNames() method.
    }

    public function setType($type)
    {
        // TODO: Implement setType() method.
    }

    public function getType()
    {
        // TODO: Implement getType() method.
    }

    public function getPath()
    {
        // TODO: Implement getPath() method.
    }

    public function setPath($path)
    {
        // TODO: Implement setPath() method.
    }

    public function setHasTranslation($hasTranslation)
    {
        // TODO: Implement setHasTranslation() method.
    }

    public function getHasTranslation()
    {
        // TODO: Implement getHasTranslation() method.
    }

    public function toArray($complete = true)
    {
        // TODO: Implement toArray() method.
    }

    public function getPropertyByTagName($tagName, $highest = true)
    {
        // TODO: Implement getPropertyByTagName() method.
    }

    public function getPropertiesByTagName($tagName)
    {
        // TODO: Implement getPropertiesByTagName() method.
    }

    public function getPropertyValueByTagName($tagName)
    {
        // TODO: Implement getPropertyValueByTagName() method.
    }

    public function hasTag($tag)
    {
        // TODO: Implement hasTag() method.
    }

    public function getNodeType()
    {
        // TODO: Implement getNodeType() method.
    }

    public function getNodeName()
    {
        // TODO: Implement getNodeName() method.
    }

    public function getLocalizedTitle($languageCode)
    {
        // TODO: Implement getLocalizedTitle() method.
    }

    public function getNodeState()
    {
        // TODO: Implement getNodeState() method.
    }

    public function copyFrom(StructureInterface $structure)
    {
        // TODO: Implement copyFrom() method.
    }

    public function jsonSerialize(): mixed
    {
        // TODO: Implement jsonSerialize() method.
    }

    public function getView(): string
    {
        return $this->outputView;
    }
}
