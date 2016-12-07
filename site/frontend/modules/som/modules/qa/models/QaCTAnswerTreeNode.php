<?php

namespace site\frontend\modules\som\modules\qa\models;

/**
 * @property int $id_ancestor
 * @property int $id_descendant
 * @property int $id_nearest_ancestor
 * @property int $level
 * @property int $id_subject
 */
class QaCTAnswerTreeNode extends \HActiveRecord
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
}