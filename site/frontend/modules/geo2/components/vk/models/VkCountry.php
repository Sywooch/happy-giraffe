<?php

namespace site\frontend\modules\geo2\components\vk\models;

/**
 * This is the model class for table "vk__countries".
 *
 * The followings are the available columns in table 'vk__countries':
 * @property string $id
 * @property string $title
 * @property string $iso
 */
class VkCountry extends \CActiveRecord
{
	const RUSSIA_ID = 1;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vk__countries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [

		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'iso' => 'Iso',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VkCountry the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
