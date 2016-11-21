<?php

namespace site\frontend\modules\specialists\models;

use site\frontend\modules\specialists\models\specialistsProfileAuthorizationTasks\ProfileTasksStatusEnum;
use site\frontend\modules\specialists\components\SpecialistsManager;
use site\frontend\modules\specialists\models\specialistsAuthorizationTasks\AuthorizationTypeEnum;

/**
 * @author Emil Vililyaev
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_relation_id
 * @property integer $status
 * @property integer $created
 * @property integer $updated
 */
class SpecialistsProfileAuthorizationTasks extends \HActiveRecord
{

    /**
     * @param system $className
     * @return Ambiguous
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * update common status(authorization_status) in SpecialistProfile
     */
    private function _updateCommonStatus()
    {
        SpecialistsManager::updateProfileAuthorizationStatus($this->user_id);
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see CActiveRecord::afterSave()
     */
    protected function afterSave()
    {
        $this->_updateCommonStatus();
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see CModel::behaviors()
     */
    public function behaviors()
    {
        return [
            'CTimestampBehavior' => [
                'class'=>'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate'=>true,
                'createAttribute'=>'created',
                'updateAttribute'=>'updated',
            ],
        ];
    }

    /**
     * @param integer $userId
     * @param integer $relationId
     * @return self
     */
    public static function getByUserAndType($userId, $relationId)
    {
        $model = parent::model(__CLASS__);

        return $model->find('user_id=' . $userId . ' AND group_relation_id=' . $relationId);
    }

    /**
     * @return boolean
     */
    public function setStatusDone()
    {
        $this->status = ProfileTasksStatusEnum::DONE;

        return $this->save();
    }

    /**
     * {@inheritDoc}
     * @see CActiveRecord::tableName()
     */
    public function tableName()
    {
        return 'specialists__profile_authorization_tasks';
    }

    /**
     * {@inheritDoc}
     * @see CActiveRecord::insert()
     */
    public function insert($attributes = NULL)
    {
        $this->status = ProfileTasksStatusEnum::CREATED;

        return parent::insert($attributes);
    }

    /**
     * {@inheritDoc}
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return [
            'user' => [self::BELONGS_TO, 'site\frontend\modules\users\models\User', 'user_id'],
        ];
    }

    public function transactions()
    {
        return [
            'update' => self::OP_UPDATE
        ];
    }
}