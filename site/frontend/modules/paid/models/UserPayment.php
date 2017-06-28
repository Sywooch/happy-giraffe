<?php

namespace site\frontend\modules\paid\models;

/**
 * @property int $user_id
 * @property int $service_id
 * @property int $paid_at
 * @property int $price
 * @property string $transaction_id
 *
 * @property \User $user
 * @property \PaidService $service
 */
class UserPayment extends \HActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users_payment';
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
            ['service_id', 'exists', 'className' => 'site\frontend\modules\paid\models\PaidService', 'caseSensitive' => false, 'criteria' =>
                ['condition' => "id = :id",
                    'params' => [
                        ':id' => $this->service_id,
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
            'service' => [self::HAS_ONE, 'PaidService', 'service_id'],
        ];
    }

    public function behaviors()
    {
        return [
            'HTimestampBehavior' => [
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'paid_at',
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User Id',
            'service_id' => 'Service Id',
            'paid_at' => 'Paid At Time',
            'price' => 'Price',
            'transaction_id' => 'Transaction Id'
        ];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserPayment the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param int $userId
     *
     * @return UserPayment
     */
    public function byUser($userId)
    {
        $this->getDbCriteria()->compare('user_id', $userId);

        return $this;
    }

    /**
     * @param int $serviceId
     *
     * @return UserPayment
     */
    public function byService($serviceId)
    {
        $this->getDbCriteria()->compare('service_id', $serviceId);

        return $this;
    }
}