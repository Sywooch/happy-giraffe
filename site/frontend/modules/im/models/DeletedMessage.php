<?php

/**
 * This is the model class for table "im__deleted_messages".
 *
 * The followings are the available columns in table 'im__deleted_messages':
 * @property string $id
 * @property string $message_id
 * @property string $user_id
 * @property string $dialog_id
 *
 * The followings are the available model relations:
 * @property Dialog $dialog
 * @property Message $message
 * @property User $user
 */
class DeletedMessage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DeletedMessage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'im__deleted_messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message_id, user_id', 'required'),
			array('message_id, user_id', 'length', 'max'=>10),
			array('dialog_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, message_id, user_id, dialog_id', 'safe', 'on'=>'search'),
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
			'dialog' => array(self::BELONGS_TO, 'ImDialogs', 'dialog_id'),
			'message' => array(self::BELONGS_TO, 'ImMessages', 'message_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'message_id' => 'Message',
			'user_id' => 'User',
			'dialog_id' => 'Dialog',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('message_id',$this->message_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('dialog_id',$this->dialog_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}