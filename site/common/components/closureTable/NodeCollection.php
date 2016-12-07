<?php

namespace site\common\components\closureTable;

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