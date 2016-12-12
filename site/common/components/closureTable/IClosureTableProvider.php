<?php
namespace site\common\components\closureTable;

interface IClosureTableProvider
{
    /**
     * @param array $params
     * @return INode
     */
    public function createNode(array $params = []);
    
    /**
     * @param $idAncestor
     * @param $idDescendant
     * @param $level
     * @param $idSubject
     * @param $idNearestAncestor
     * @return ITreeNode
     */
    public function createNodeTree($idAncestor, $idDescendant, $level, $idSubject, $idNearestAncestor);
    
    /**
     * Дерево в формате:
     * [[node.id, node.content, tree.id_ancestor, tree.id_descendant, tree.id_nearest_ancestor, tree.level]]
     *
     * @param $subjectId
     * @return array[]
     */
    public function fetchTree($subjectId);
    
    /**
     * Все ноды по айдишникам
     *
     * @param array $id
     * @return INode[]
     */
    public function fetchNodes(array $id);

    /**
     * @param $subjectId
     * @param $ancestorId
     * @return ITreeNode[]
     */
    public function getAncestors($subjectId, $ancestorId);
}