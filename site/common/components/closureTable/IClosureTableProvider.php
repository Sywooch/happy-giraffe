<?php
namespace site\common\components\closureTable;

interface IClosureTableProvider
{
    /**
     * @param array $params
     * @return INode
     */
    public function createNode(array $params = []);
}