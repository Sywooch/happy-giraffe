<?php

namespace site\frontend\modules\paid\models;
use Carbon\Carbon;

/**
 * @property int $user_id
 * @property int $payment_id
 * @property int $paid_at
 * @property int $sum
 * @property int $service_id
 *
 * @property \site\frontend\modules\paid\models\UserPayment $payment
 * @property \site\frontend\modules\paid\models\PaidService $service
 * @property \User $user
 */
class UserBalanceRecord extends \HActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users__balance_records';
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
            ['payment_id', 'exists', 'className' => 'site\frontend\modules\paid\models\UserPayment', 'caseSensitive' => false, 'criteria' =>
                ['condition' => "id = :id",
                    'params' => [
                        ':id' => $this->payment_id,
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
            'payment' => [self::HAS_ONE, 'site\frontend\modules\paid\models\UserPayment', 'payment_id'],
            'service' => [self::HAS_ONE, 'site\frontend\modules\paid\models\PaidService', 'service_id'],
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
            'user_id' => 'User ID',
            'payment_id' => 'Payment ID',
            'paid_at' => 'Paid At',
            'sum' => 'Sum',
            'service_id' => 'Service ID',
        ];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserBalanceRecord the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param int $userId
     *
     * @return \site\frontend\modules\paid\models\UserBalanceRecord
     */
    public function byUserId($userId)
    {
        $this->getDbCriteria()->compare('user_id', $userId);

        return $this;
    }

    /**
     * @param int $paymentId
     *
     * @return \site\frontend\modules\paid\models\UserBalanceRecord
     */
    public function byPaymentId($paymentId)
    {
        $this->getDbCriteria()->compare('payment_id', $paymentId);

        return $this;
    }

    /**
     * @param int $serviceId
     *
     * @return \site\frontend\modules\paid\models\UserBalanceRecord
     */
    public function byServiceId($serviceId)
    {
        $this->getDbCriteria()->compare('service_id', $serviceId);

        return $this;
    }

    /**
     * @return UserBalanceRecord
     */
    public function today()
    {
        $this->getDbCriteria()->addCondition('paid_at > ' . Carbon::today()->timestamp);
        $this->getDbCriteria()->addCondition('paid_at < ' . Carbon::now()->timestamp);

        return $this;
    }
}