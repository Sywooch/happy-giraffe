<?php
/**
 * @author Никита
 * @date 07/06/16
 */

namespace site\frontend\modules\comments\behaviors;


use site\frontend\modules\comments\models\Comment;

class CommentableBehavior extends \CActiveRecordBehavior
{
    public $relationParameters = [];
    public $fk = 'entity_id';
    public $joinOn;
    
    public function attach($owner)
    {
        parent::attach($owner);

        if ($this->fk == 'entity_id') {
            $this->relationParameters = \CMap::mergeArray([
                'condition' => 'entity = :class',
                'params' => [':class' => get_class($owner)],
            ], $this->relationParameters);
        }

        $this->owner->getMetaData()->addRelation('commentsCount', \CMap::mergeArray([
            \CActiveRecord::STAT,
            'site\frontend\modules\comments\models\Comment',
            $this->fk,
        ], $this->relationParameters));
        $this->owner->getMetaData()->addRelation('commentatorsCount', \CMap::mergeArray([
            \CActiveRecord::STAT,
            'site\frontend\modules\comments\models\Comment',
            $this->fk,
            'select' => 'COUNT(DISTINCT ' . $owner->getTableAlias(true) . '.author_id)',
        ], $this->relationParameters));
    }

    public function uncommented()
    {
        $criteria = new \CDbCriteria();
        if ($this->joinOn === null) {
            $this->joinOn = 'commentable.entity_id = ' . $this->owner->getTableAlias(true) . '.id AND commentable.entity = "' . get_class($this->owner) . '"';
        }
        $criteria->join = 'LEFT OUTER JOIN ' . Comment::model()->tableName() . ' commentable ON ' . $this->joinOn;
        $criteria->addCondition('commentable.id IS NULL');
        $this->owner->getDbCriteria()->mergeWith($criteria);
        return $this->owner;
    }
}