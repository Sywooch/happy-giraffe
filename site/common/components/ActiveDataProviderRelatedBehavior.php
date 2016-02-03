<?php
namespace site\common\components;

/**
 * Class ActiveDataProviderRelatedBehavior
 * @package site\common\components
 *
 * @var \CActiveDataProvider $owner
 */

class ActiveDataProviderRelatedBehavior extends \CBehavior
{
    public $relations = array();

    public function test()
    {
        echo '444';
    }

    public function getData()
    {
        return '123';

        $data = $this->owner->getData();

        foreach ($this->relations as $relationName) {
            $relation = $this->owner->model->getMetaData()->relations[$relationName];

            if (! $relation instanceof \CBelongsToRelation) {
                throw new \CException('Behavior must be instance of CBelongsToRelation class');
            }

            $ids = array();
            /** @var \site\frontend\modules\som\modules\qa\models\QaQuestion $question */
            foreach ($data as $model) {
                $ids[] = $model->{$relation->foreignKey};
            }

            $criteria = new \CDbCriteria();
            $criteria->addInCondition('t.id', $ids);
            $criteria->index = 'id';
            $categories = \CActiveRecord::model($relation->className)->findAll($criteria);

            /** @var \site\frontend\modules\som\modules\qa\models\QaQuestion $question */
            foreach ($data as &$model) {
                $model->addRelatedRecord($relationName, $categories[$model->{$relation->foreignKey}], false);
            }
        }

        return $data;
    }
}