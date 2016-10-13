<?php

namespace site\frontend\modules\specialists\models;

/**
 * @author Emil Vililyaev
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $task_id
 */
class SpecialistGroupTaskRelation extends \CActiveRecord
{

    /**
     * {@inheritDoc}
     * @see CActiveRecord::tableName()
     */
    public function tableName()
    {
        return 'specialists__group_type_relation';
    }

    /**
     * {@inheritDoc}
     * @see CActiveRecord::relations()
     */
//     public function relations()
//     {
//         return [
//             'task' => [self::BELONGS_TO, 'site\frontend\modules\specialists\models\SpecialistsAuthorizationTasks', 'id'],
//             'group' => [self::BELONGS_TO, 'site\frontend\modules\specialists\models\SpecialistProfile', 'id'],
//         ];
//     }

}