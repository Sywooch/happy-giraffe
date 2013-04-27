<?php

/**
 * This is the model class for table "friends_requests".
 *
 * The followings are the available columns in table 'friends_requests':
 * @property string $id
 * @property string $from_id
 * @property string $to_id
 * @property string $text
 * @property string $status
 * @property integer $read_status
 * @property string $updated
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $from
 * @property User $to
 */
class FriendRequest extends HActiveRecord
{
    private $_status = array(
        'pending' => 'В обработке',
        'accepted' => 'Принято',
        'declined' => 'Отклонено',
    );

    public $text = 'Привет! Давай дружить?';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FriendRequest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function afterSave()
    {
        if ($this->isNewRecord) {
            $comet = new CometModel;
            $comet->send($this->to_id, null, CometModel::TYPE_NEW_FRIEND_REQUEST);
        }

        parent::afterSave();
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'friend_requests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
        return array(
            array('from_id, to_id, text', 'required'),
            array('from_id', 'exist', 'className' => 'User', 'attributeName' => 'id'),
            array('to_id', 'exist', 'className' => 'User', 'attributeName' => 'id'),
            array('status', 'in', 'range' => array('pending', 'accepted', 'declined')),
            array('read_status', 'boolean'),
            array('to_id', 'compare', 'compareAttribute' => 'from_id', 'operator' => '!=', 'message' => 'Вы не можете отправить приглашение самому себе.'),
            array('to_id', 'alreadySent', 'on' => 'insert'),
        );
	}

    public function alreadySent($attribute, $params)
    {
        if (self::model()->findByAttributes(array(
            'from_id' => $this->from_id,
            'to_id' => $this->to_id,
            'status' => 'pending',
        )) !== null) $this->addError($attribute, 'Вы уже отправили этому пользователю приглашение.');
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'from' => array(self::BELONGS_TO, 'User', 'from_id'),
			'to' => array(self::BELONGS_TO, 'User', 'to_id'),
		);
	}

    public function behaviors(){
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            )
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from_id' => 'От кого',
			'to_id' => 'Кому',
			'text' => 'Текст',
			'status' => 'Статус',
			'read_status' => 'Прочитано',
			'created' => 'Создано',
            'updated' => 'Обновлено',
		);
	}

    public function getStatusLabel()
    {
        return $this->_status[$this->status];
    }

    public function getUserCount($user_id)
    {
        return $this->countByAttributes(array('to_id' => $user_id, 'status' => 'pending'));
    }

    public function getCountByUserId($userId, $incoming = true)
    {
        return $this->countByAttributes(array($incoming ? 'to_id' : 'from_id' => $userId, 'status' => 'pending'));
    }
}