<?php

namespace site\frontend\modules\specialists\models;

/**
 * @author Emil Vililyaev
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $task_id
 */
class SpecialistGroupTaskRelation extends \HActiveRecord
{

    /**
     * @param system $className
     * @return self
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * {@inheritDoc}
     * @see CActiveRecord::tableName()
     */
    public function tableName()
    {
        return 'specialists__group_type_relation';
    }

    /**
     * @param integer $groupId
     * @param integer $taskId
     * @return self
     */
    public function getByGroupAndTask($groupId, $taskId)
    {
        return $this->find('group_id=' . $groupId . ' AND ' . 'task_id=' . $taskId);
    }

}