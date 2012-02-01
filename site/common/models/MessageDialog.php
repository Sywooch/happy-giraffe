<?php

/**
 * This is the model class for table "message_dialog".
 *
 * The followings are the available columns in table 'message_dialog':
 * @property string $id
 * @property string $cache
 * @property string $title
 *
 * The followings are the available model relations:
 * @property MessageLog[] $messageLogs
 * @property MessageUser[] $messageUsers
 */
class MessageDialog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MessageDialog the static model class
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
		return 'message_dialog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cache', 'required'),
			array('cache, title', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cache, title', 'safe', 'on'=>'search'),
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
			'messageLogs' => array(self::HAS_MANY, 'MessageLog', 'dialog_id'),
			'messageUsers' => array(self::HAS_MANY, 'MessageUser', 'dialog_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cache' => 'Cache',
			'title' => 'Title',
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
		$criteria->compare('cache',$this->cache,true);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function SetRead($dialog_id)
    {
        $user_id = Yii::app()->user->getId();
    }
}