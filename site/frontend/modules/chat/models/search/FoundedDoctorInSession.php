<?php

namespace site\frontend\modules\chat\models\search;

/**
 * @property int $session_id
 * @property int $doctor_id
 *
 * @property \User $doctor
 * @property \site\frontend\modules\chat\models\search\SearchDoctorSession $session
 */
class FoundedDoctorInSession extends \HActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'founded_doctors_in_sessions';
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
                ['condition' => "deleted = 0 and status = :active and id = :id and specialistInfo is not null and specialistInfo != ''",
                    'params' => [
                        ':active' => \User::STATUS_ACTIVE,
                        ':id' => $this->doctor_id,
                    ]
                ]
            ],
            ['session_id', 'exists', 'className' => 'site\frontend\modules\chat\models\search\SearchDoctorSession', 'caseSensitive' => false, 'criteria' =>
                ['condition' => "id = :id",
                    'params' => [
                        ':id' => $this->session_id,
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
            'doctor' => [self::HAS_ONE, 'User', 'doctor_id'],
            'session' => [self::HAS_ONE, 'site\frontend\modules\chat\models\search\SearchDoctorSession', 'session_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'doctor_id' => 'Doctor Id',
            'session_id' => 'Session Id',
        ];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FoundedDoctorInSession the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}