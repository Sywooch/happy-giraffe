<?php

namespace site\frontend\modules\chat\models\search;

/**
 * @property int $id
 * @property int $user_id
 * @property int $expires_in
 *
 * @property \User $user
 */
class SearchDoctorSession extends \HActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'search_doctors_sessions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['doctor_id', 'exists', 'className' => 'User', 'caseSensitive' => false, 'criteria' =>
                ['condition' => "deleted = 0 and status = :active and id = :id and (specialistInfo is null or specialistInfo = '')",
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
            'id' => 'Id',
            'user_id' => 'User Id',
            'expires_in' => 'Expires In',
        ];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SearchDoctorSession the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}