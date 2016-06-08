<?php
/**
 * @author Никита
 * @date 07/06/16
 */

namespace site\frontend\modules\comments\behaviors;


use site\frontend\modules\comments\models\Comment;

class CommentableBehavior extends \CActiveRecordBehavior
{
    public $relationParameters;

    public function attach($owner)
    {
        parent::attach($owner);

        if ($this->relationParameters === null) {
            $this->relationParameters = [
                'condition' => 'entity = :class',
                'params' => [':class' => get_class($owner)],
            ];
        }

        $this->owner->getMetaData()->addRelation('commentsCount', \CMap::mergeArray([
            \CActiveRecord::STAT,
            'site\frontend\modules\comments\models\Comment',
            'entity_id',
        ], $this->relationParameters));
        $this->owner->getMetaData()->addRelation('commentatorsCount', \CMap::mergeArray([
            \CActiveRecord::STAT,
            'site\frontend\modules\comments\models\Comment',
            'entity_id',
            'select' => 'COUNT(DISTINCT t.author_id)',
        ], $this->relationParameters));
    }

    public function uncommented()
    {
        $criteria = new \CDbCriteria();
        $criteria->join = 'LEFT OUTER JOIN ' . Comment::model()->tableName() . ' c ON c.entity_id = t.originEntityId AND c.entity = t.originEntity';
        $criteria->addCondition('c.id IS NULL');
        $this->owner->getDbCriteria()->mergeWith($criteria);
        return $this->owner;
    }
}