<?php

/**
 * This is the model class for table "user__mail_subs".
 *
 * The followings are the available columns in table 'user__mail_subs':
 * @property string $user_id
 * @property integer $weekly_news
 * @property integer $new_messages
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserMailSub extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserMailSub the static model class
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
		return 'user__mail_subs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('user_id', 'required'),
			array('weekly_news, new_messages', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('user_id, weekly_news, new_messages', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}
}