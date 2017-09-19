<?php

namespace Neos\ContentRepository\Domain\Context\Node\Event;

use Neos\ContentRepository\Domain\ValueObject\EditingSessionIdentifier;
use Neos\ContentRepository\Domain\ValueObject\NodeIdentifier;
use Neos\ContentRepository\Domain\ValueObject\PropertyValue;

final class PropertyWasSet
{

    /**
     * @var NodeIdentifier
     */
    private $nodeIdentifier;

    /**
     * @var string
     */
    private $propertyName;

    /**
     * @var PropertyValue
     */
    private $value;

    /**
     *
     * @param EditingSessionIdentifier $editingSessionIdentifier
     * @param NodeIdentifier $nodeIdentifier
     * @param string $propertyName
     * @param PropertyValue $value
     */
    public function __construct(
        EditingSessionIdentifier $editingSessionIdentifier,
        NodeIdentifier $nodeIdentifier,
        $propertyName,
        PropertyValue $value
    ) {
        $this->nodeIdentifier = $nodeIdentifier;
        $this->propertyName = $propertyName;
        $this->value = $value;
    }

    /**
     * @return NodeIdentifier
     */
    public function getNodeIdentifier(): NodeIdentifier
    {
        return $this->nodeIdentifier;
    }

    /**
     * @return string
     */
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @return PropertyValue
     */
    public function getValue(): PropertyValue
    {
        return $this->value;
    }
}
