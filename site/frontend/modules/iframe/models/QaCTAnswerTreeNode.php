<?php

namespace site\frontend\modules\iframe\models;

use site\common\components\closureTable\ITreeNode;

/**
 * @property int $id_ancestor
 * @property int $id_descendant
 * @property int $id_nearest_ancestor
 * @property int $level
 * @property int $id_subject
 */
class QaCTAnswerTreeNode extends \HActiveRecord implements ITreeNode
{
    public function tableName()
    {
        return 'qa__answers_new_tree';
    }
    
    public function byAncestorId($ancestorId)
    {
        $this->getDbCriteria()->addColumnCondition(['id_ancestor' => $ancestorId]);
        
        return $this;
    }
    
    public function byDescendantId($descendantId)
    {
        $this->getDbCriteria()->addColumnCondition(['id_descendant' => $descendantId]);
        
        return $this;
    }

    public function bySubjectId($subjectId)
    {
        $this->getDbCriteria()->addColumnCondition(['id_subject' => $subjectId]);

        return $this;
    }
    
#region ITreeNode
    public function getAncestorId()
    {
        return $this->id_ancestor;
    }
    
    public function setAncestorId($id)
    {
        $this->id_ancestor = $id;
    }
    
    public function getDescendantId()
    {
        return $this->id_descendant;
    }
    
    public function setDescendantId($id)
    {
        $this->id_descendant = $id;
    }
    
    public function getNearestAncestor()
    {
        return $this->id_nearest_ancestor;
    }
    
    public function setNearestAncestor($id)
    {
        $this->id_nearest_ancestor = $id;
    }
    
    public function getLevel()
    {
        return $this->level;
    }
    
    public function setLevel($level)
    {
        $this->level = $level;
    }
    
    public function getSubjectId()
    {
        return $this->id_subject;
    }
    
    public function setSubjectId($id)
    {
        $this->id_subject = $id;
    }
#endregion
}