<?php

namespace site\common\components\closureTable;

class ClosureTableManager
{
    /***
     * @var IClosureTableProvider
     */
    protected $provider;

    public function __construct(IClosureTableProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param array $params
     * @return INode
     */
    public function createNode(array $params = [])
    {
        return $this->provider->createNode($params);
    }

    /**
     * @param INode $node
     * @param $subjectId
     * @param INode|null $ancestorNode
     * @return ITreeNode|ITreeNode[]
     */
    public function attach(INode $node, $subjectId, INode $ancestorNode = null)
    {
        if ($ancestorNode === null) { // Вяжем первым уровнем к subject
            return $this->provider->createNodeTree($node->getId(), $node->getId(), 0, $subjectId, 0);
        } else { // Вложенность
            $ancestors = $this->provider->getAncestors($subjectId, $ancestorNode->getId());

            $level = $ancestors[0]->getLevel() + 1;
            $nearestAncestorId = 0;

            foreach ($ancestors as $ancestor) {
                $nearestAncestorId = max($nearestAncestorId, $ancestor->getAncestorId());
            }

            /** @var ITreeNode[] $treeNodes */
            $treeNodes = [];

            foreach ($ancestors as $ancestor) {
                $treeNodes[] = $this->provider->createNodeTree($ancestor->getAncestorId(), $node->getId(), $level, $subjectId, $nearestAncestorId);
            }

            $this->provider->createNodeTree($node->getId(), $node->getId(), $level, $subjectId, $nearestAncestorId);

            return $treeNodes;
        }
    }

    /**
     * @param $subjectId
     * @return INode[]
     */
    public function getNodeTree($subjectId)
    {
        $collection = new NodeCollection();
        $collection->rows = $this->provider->fetchTree($subjectId);

        $ids = [];

        foreach ($collection->rows as $row) {
            if (!in_array($row['id'], $ids)) {
                $ids[] = $row['id'];
            }
        }

        $collection->nodes = $this->provider->fetchNodes($ids);

        return $this->buildNode($collection);
    }

    /**
     * @param $nodeId
     * @return INode
     */
    public function getNode($nodeId)
    {
        return $this->provider->fetchNode($nodeId);
    }

    protected function buildNode(NodeCollection $collection, $level = 0, $ancestorId = null)
    {
        return array_map(function ($row) use ($collection, $level) {
            $node = $collection->fetchNode($row['id']);

            foreach ($this->buildNode($collection, $level + 1, $node->getId()) as $item) {
                $node->appendChild($item);
            }

            return $node;
        }, array_filter($collection->rows, function ($row) use ($level, $ancestorId) {
            if ($row['level'] == $level && ($ancestorId === null || $ancestorId == $row['id_ancestor'])) {
                return true;
            }

            return false;
        }));
    }
}