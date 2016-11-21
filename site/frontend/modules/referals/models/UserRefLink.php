<?php

namespace site\frontend\modules\referals\models;
use site\frontend\modules\referals\components\ReferalsEvents;
use site\frontend\modules\referals\components\ReferalsManager;

/**
 * This is the model class for table "user__ref_links".
 *
 * The followings are the available columns in table 'user__ref_links':
 * @property int $id
 * @property int $user_id
 * @property string $ref
 * @property int $event
 *
 * The followings are the available model relations:
 * @property \User $user
 */
class UserRefLink extends \HActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user__ref_links';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, ref, event', 'required'),
            array('user_id', 'exist', 'attributeName' => 'id', 'className' => get_class(\User::model())),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, get_class(\User::model()), 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'ref' => 'Referal Link',
            'event' => 'Event',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserRefLink the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param int $userId
     *
     * @return UserRefLink
     */
    public function byUser($userId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.user_id', $userId);
        return $this;
    }

    /**
     * @param string $ref
     *
     * @return UserRefLink
     */
    public function byRef($ref)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.ref', $ref);
        return $this;
    }

    /**
     * @param int $event
     *
     * @return UserRefLink
     */
    public function byEvent($event)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.event', $event);
        return $this;
    }

    /**
     * @param int $event
     *
     * @throws \Exception
     *
     * @return UserRefLink
     */
    public static function generate($event)
    {
        if (!ReferalsManager::validateEvent($event)) {
            throw new \Exception('ReferalEventNotFound');
        }

        $model = new self;

        $model->user_id = \Yii::app()->user->id;
        $model->ref = md5($model->user_id . microtime() . $event);
        $model->event = $event;

        return $model;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return \Yii::app()->request->hostInfo . '/referals/' . $this->ref;
    }
}
