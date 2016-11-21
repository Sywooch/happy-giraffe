<?php

namespace site\frontend\modules\specialists\models;

/**
 * @author Emil Vililyaev
 *
 * @property integer $id
 * @property integer $task_type
 */
class SpecialistsAuthorizationTasks extends \HActiveRecord
{

    /**
     * {@inheritDoc}
     * @see CActiveRecord::tableName()
     */
    public function tableName()
    {
        return 'specialists__authorization_tasks';
    }

}