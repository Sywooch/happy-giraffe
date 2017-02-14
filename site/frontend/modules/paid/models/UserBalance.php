<?php

namespace site\frontend\modules\paid\models;

/**
 * @property int $user_id
 * @property int sum
 *
 * @property \User $user
 */
class UserBalance extends \HActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users_balance';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['user_id', 'exists', 'className' => 'User', 'caseSensitive' => false, 'criteria' =>
                ['condition' => "deleted = 0 and status = :active and id = :id",
                    'params' => [
                        ':active' => \User::STATUS_ACTIVE,
                        ':id' => $this->user_id,
                    ]
                ]
            ],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'user' => [self::HAS_ONE, 'User', 'user_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'sum' => 'Sum',
        ];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserBalance the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param int $userId
     *
     * @return \site\frontend\modules\paid\models\UserBalance
     */
    public function byUserId($userId)
    {
        $this->getDbCriteria()->compare('user_id', $userId);

        return $this;
    }
}