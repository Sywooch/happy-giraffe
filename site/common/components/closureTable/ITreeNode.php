<?php
namespace site\common\components\closureTable;

interface ITreeNode
{
    public function getAncestorId();
    
    public function setAncestorId($id);
    
    public function getDescendantId();
    
    public function setDescendantId($id);
    
    public function getNearestAncestor();
    
    public function setNearestAncestor($id);
    
    public function getLevel();
    
    public function setLevel($level);
    
    public function getSubjectId();
    
    public function setSubjectId($id);
}