<?php
/**
 * Created by PhpStorm.
 * User: JimmDiGriz
 * Date: 03.05.2017
 * Time: 10:43
 */

namespace site\frontend\modules\specialists\models;

/**
 * @property int $user_id
 * @property int $conducted_chats_count
 * @property int $skipped_chats_count
 * @property int $failed_chats_count
 * @property string $date
 *
 * @property \User $user
 */
class ChatStatisticHistory extends \HActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'chat__statistics_history';
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
                ['condition' => "deleted = 0 and status = :active and id = :id and specialistInfo is not null and specialistInfo != ''",
                    'params' => [
                        ':active' => \User::STATUS_ACTIVE,
                        ':id' => $this->user_id,
                    ]
                ]
            ],
            [['conducted_chats_count', 'skipped_chats_count', 'failed_chats_count'], 'numerical', 'integerOnly' => true, 'min' => 0],
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
            'conducted_chats_count' => 'Conducted Chats Count',
            'skipped_chats_count' => 'Skipped Chats Count',
            'failed_chats_count' => 'Failed Chats Count',
            'date' => 'Date',
        ];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ChatStatisticHistory the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param int $userId
     *
     * @return ChatStatisticHistory
     */
    public function byUserId($userId)
    {
        $this->getDbCriteria()->compare('user_id', $userId);

        return $this;
    }

    /**
     * @param string $date
     *
     * @return ChatStatisticHistory
     */
    public function byDate($date)
    {
        $this->getDbCriteria()->compare('date', $date);

        return $this;
    }

    /**
     * @return ChatStatisticHistory
     */
    public function today()
    {
        $this->getDbCriteria()->addCondition('date = CURDATE()');

        return $this;
    }

    /**
     * @param int $userId
     * @param string $field
     *
     * @return bool
     */
    public static function increment($userId, $field)
    {
        $record = ChatStatisticHistory::model()
            ->byUserId($userId)
            ->today()
            ->find();

        if (!$record) {
            $record = new ChatStatisticHistory();

            $record->user_id = $userId;
            $record->date = new \CDbExpression('CURDATE()');
        }

        $record->setAttribute($field, $record->getAttribute($field) + 1);

        return $record->save();
    }
}