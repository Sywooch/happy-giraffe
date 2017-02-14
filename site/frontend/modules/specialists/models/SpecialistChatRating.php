<?php

namespace site\frontend\modules\specialists\models;

/**
 * @property int $specialist_id
 * @property int $chat_id
 * @property int $rating
 *
 * @property \User $user
 * property \site\frontend\modules\chat\models\Chat $chat
 */
class SpecialistChatRating extends \HActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'specialists__chats_rating';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['rating', 'in', 'range' => [1,2,3,4,5], 'allowEmpty' => false],
            ['specialist_id', 'exists', 'className' => 'User', 'caseSensitive' => false, 'criteria' =>
                ['condition' => "deleted = 0 and status = :active and id = :id and specialistInfo is not null and specialistInfo != ''",
                    'params' => [
                        ':active' => \User::STATUS_ACTIVE,
                        ':id' => $this->specialist_id,
                    ]
                ]
            ],
            ['chat_id', 'exists', 'className' => 'site\frontend\modules\chat\models\Chat', 'caseSensitive' => false, 'criteria' =>
                ['condition' => "id = :id",
                    'params' => [
                        ':id' => $this->chat_id,
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
            'user' => [self::HAS_ONE, 'User', 'specialist_id'],
            'chat' => [self::HAS_ONE, 'site\frontend\modules\chat\models\Chat', 'chat_id']
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'specialist_id' => 'Specialist Id',
            'chat_id' => 'Chat Id',
            'rating' => 'Rating',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SpecialistChatRating the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param int $specialistId
     *
     * @return SpecialistChatRating
     */
    public function bySpecialist($specialistId)
    {
        $this->getDbCriteria()->compare('specialist_id', $specialistId);

        return $this;
    }

    /**
     * @param int $rating
     *
     * @return SpecialistChatRating
     */
    public function ratingGreaterThen($rating)
    {
        $this->getDbCriteria()->compare('rating', "> {$rating}");

        return $this;
    }

    /**
     * @param int $rating
     *
     * @return SpecialistChatRating
     */
    public function ratingLesserThen($rating)
    {
        $this->getDbCriteria()->compare('rating', "< {$rating}");

        return $this;
    }

    /**
     * @param int $rating
     *
     * @return SpecialistChatRating
     */
    public function ratingEquals($rating)
    {
        $this->getDbCriteria()->compare('rating', $rating);

        return $this;
    }
}
