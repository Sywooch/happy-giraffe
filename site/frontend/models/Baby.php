<?php

class Baby extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{user_baby}}';
	}

	public function relations()
	{
		return array(
			'parent' => array(self::BELONGS_TO, 'User', 'id'),
		);
	}
	
	public function rules()
	{
		return array(
			array('birthday', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
			array('name', 'length', 'max'=>255),
		);
	}
    
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Родитель',
			'age_group' => 'Возрастная группа',
			'name' => 'Имя',
			'birthday' => 'День рождения',
		);
	}
}