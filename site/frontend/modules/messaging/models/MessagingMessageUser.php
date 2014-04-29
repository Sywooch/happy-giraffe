<?php

/**
 * This is the model class for table "messaging__messages_users".
 *
 * The followings are the available columns in table 'messaging__messages_users':
 * @property string $user_id
 * @property string $message_id
 * @property integer $deleted
 * @property string $dtime_read
 * @property string $dtime_delete
 * 
 * @property MessagingMessage $message Связанная модель сообщения
 */
class MessagingMessageUser extends HActiveRecord
{
    public $unreadCount;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MessagingMessageUser the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'messaging__messages_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('dtime_read, dtime_delete', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('user_id, message_id, read, deleted', 'safe', 'on' => 'search'),
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
			'message' => array(self::BELONGS_TO, 'MessagingMessage', 'message_id'),
			//'thread' => array(self::BELONGS_TO, 'MessagingThread'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'message_id' => 'Message',
			'read' => 'Read',
			'deleted' => 'Deleted',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('message_id', $this->message_id, true);
		$criteria->compare('read', $this->read);
		$criteria->compare('deleted', $this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	// SCOPES
	public function scopes()
	{
		return array(
			'unread' => array(
				'condition' => $this->tableAlias . '.`dtime_read` IS NULL AND ' . $this->tableAlias . '.`dtime_delete` IS NOT NULL',
			),
		);
	}
	
	/**
	 * Параметризованный scope, накладывает ограничение по пользователю
	 * 
	 * @param mixed $user Модель пользователя, или его id
	 * @return MessagingMessageUser
	 */
	public function user($user)
	{
		if ($user instanceof CActiveRecord)
			$user = $user->id;
		$user = (int) $user;
		
		$this->dbCriteria->addColumnCondition(array(
			$this->tableAlias . '.`user_id`' => $user,
		));
		
		return $this;
	}

}