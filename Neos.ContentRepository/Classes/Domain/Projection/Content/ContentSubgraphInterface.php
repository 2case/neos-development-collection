<?php

namespace Neos\ContentRepository\Domain\Projection\Content;

/*
 * This file is part of the Neos.ContentRepository package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */
use Neos\ContentRepository\Domain;
use Neos\Flow\Annotations as Flow;

/**
 * The interface to be implemented by content subgraphs
 */
interface ContentSubgraphInterface
{
    /**
     * @param Domain\Model\NodeInterface $startNode
     * @param Domain\ValueObject\NodeTypeConstraints $nodeTypeConstraints
     * @param callable $callback
     * @param Domain\Service\Context|null $contentContext
     */
    public function traverse(Domain\Model\NodeInterface $startNode, Domain\ValueObject\NodeTypeConstraints $nodeTypeConstraints, callable $callback, Domain\Service\Context $contentContext = null): void;

    /**
     * @param Domain\ValueObject\NodeIdentifier $nodeIdentifier
     * @param Domain\Service\Context|null $contentContext
     * @return Domain\Model\NodeInterface|null
     */
    public function findNodeByIdentifier(Domain\ValueObject\NodeIdentifier $nodeIdentifier, Domain\Service\Context $contentContext = null): ?Domain\Model\NodeInterface;

    /**
     * @param Domain\ValueObject\NodeIdentifier $parentNodeIdentifier
     * @param Domain\ValueObject\NodeTypeConstraints $nodeTypeConstraints
     * @param int|null $limit
     * @param int|null $offset
     * @param Domain\Service\Context|null $contentContext
     * @return array|Domain\Model\NodeInterface[]
     */
    public function findChildNodes(Domain\ValueObject\NodeIdentifier $parentNodeIdentifier, Domain\ValueObject\NodeTypeConstraints $nodeTypeConstraints = null, int $limit = null, int $offset = null, Domain\Service\Context $contentContext = null): array;

    /**
     * @param Domain\ValueObject\NodeAggregateIdentifier $nodeAggregateIdentifier
     * @param Domain\Service\Context|null $contentContext
     * @return Domain\Model\NodeInterface|null
     */
    public function findNodeByNodeAggregateIdentifier(Domain\ValueObject\NodeAggregateIdentifier $nodeAggregateIdentifier, Domain\Service\Context $contentContext = null): ?Domain\Model\NodeInterface;


    /**
     * @param Domain\ValueObject\NodeIdentifier $parentIdentifier
     * @param Domain\ValueObject\NodeTypeConstraints|null $nodeTypeConstraints
     * @param Domain\Service\Context|null $contentContext
     * @return int
     */
    public function countChildNodes(Domain\ValueObject\NodeIdentifier $parentIdentifier, Domain\ValueObject\NodeTypeConstraints $nodeTypeConstraints = null, Domain\Service\Context $contentContext = null): int;

    /**
     * @param Domain\ValueObject\NodeIdentifier $childIdentifier
     * @param Domain\Service\Context|null $contentContext
     * @return Domain\Model\NodeInterface|null
     */
    public function findParentNode(Domain\ValueObject\NodeIdentifier $childIdentifier, Domain\Service\Context $contentContext = null): ?Domain\Model\NodeInterface;

    /**
     * @param Domain\ValueObject\NodeIdentifier $parentIdentifier
     * @param Domain\Service\Context|null $contentContext
     * @return Domain\Model\NodeInterface|null
     */
    public function findFirstChildNode(Domain\ValueObject\NodeIdentifier $parentIdentifier, Domain\Service\Context $contentContext = null): ?Domain\Model\NodeInterface;

    /**
     * @param string $path
     * @param Domain\Service\Context|null $contentContext
     * @return Domain\Model\NodeInterface|null
     */
    public function findNodeByPath(string $path, Domain\Service\Context $contentContext = null): ?Domain\Model\NodeInterface;

    /**
     * @param Domain\ValueObject\NodeIdentifier $parentIdentifier
     * @param Domain\ValueObject\NodeName $edgeName
     * @param Domain\Service\Context|null $contentContext
     * @return Domain\Model\NodeInterface|null
     */
    public function findChildNodeConnectedThroughEdgeName(Domain\ValueObject\NodeIdentifier $parentIdentifier, Domain\ValueObject\NodeName $edgeName, Domain\Service\Context $contentContext = null): ?Domain\Model\NodeInterface;

    /**
     * @param Domain\ValueObject\NodeTypeName $nodeTypeName
     * @param Domain\Service\Context|null $contentContext
     * @return array|Domain\Model\NodeInterface[]
     */
    public function findNodesByType(Domain\ValueObject\NodeTypeName $nodeTypeName, Domain\Service\Context $contentContext = null): array;

    /**
     * @param Domain\Service\Context|null $context
     * @return Domain\Model\NodeInterface|null
     */
    public function findRootNode(Domain\Service\Context $context = null): ?Domain\Model\NodeInterface;

    /**
     * @return Domain\ValueObject\ContentStreamIdentifier
     */
    public function getContentStreamIdentifier(): Domain\ValueObject\ContentStreamIdentifier;

    /**
     * @return Domain\ValueObject\DimensionSpacePoint
     */
    public function getDimensionSpacePoint(): Domain\ValueObject\DimensionSpacePoint;
}
