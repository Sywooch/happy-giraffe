<?php

namespace site\common\components\closureTable;

class ClosureTableManager
{
    /***
     * @var IClosureTableProvider
     */
    protected $provider;
    
    public function setProvider(IClosureTableProvider $provider)
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
    
    public function applyTo()
    {
        
    }
}