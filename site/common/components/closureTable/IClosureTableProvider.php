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
     * @return mixed
     */
    public function createNodeTree($idAncestor, $idDescendant, $level, $idSubject, $idNearestAncestor);
    
    /**
     * @param $subjectId
     * @return object[]
     */
    public function fetchTree($subjectId);
    
    /**
     * @param array $id
     * @return INode[]
     */
    public function fetchNodes(array $id);
}