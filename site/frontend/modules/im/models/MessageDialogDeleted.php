<?php

/**
 * This is the model class for table "message_dialog_deleted".
 *
 * The followings are the available columns in table 'message_dialog_deleted':
 * @property string $dialog_id
 * @property string $message_id
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property MessageDialog $dialog
 * @property MessageLog $message
 * @property User $user
 */
class MessageDialogDeleted extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MessageDialogDeleted the static model class
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
		return 'message_dialog_deleted';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dialog_id, message_id, user_id', 'required'),
			array('dialog_id, message_id, user_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dialog_id, message_id, user_id', 'safe', 'on'=>'search'),
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
			'dialog' => array(self::BELONGS_TO, 'MessageDialog', 'dialog_id'),
			'message' => array(self::BELONGS_TO, 'MessageLog', 'message_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dialog_id' => 'Dialog',
			'message_id' => 'Message',
			'user_id' => 'User',
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

		$criteria->compare('dialog_id',$this->dialog_id,true);
		$criteria->compare('message_id',$this->message_id,true);
		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}