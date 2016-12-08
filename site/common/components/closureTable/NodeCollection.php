<?php

namespace site\common\components\closureTable;

/**
 * Список нод и элементов дерева. Вспомогательный класс
 */
class NodeCollection
{
    /**
     * @var INode
     */
    public $nodes = [];
    
    /**
     * @var array
     */
    public $rows = [];
    
    /**
     * @param $id
     * @return INode
     */
    public function fetchNode($id)
    {
        return $this->nodes[$id];
    }
}