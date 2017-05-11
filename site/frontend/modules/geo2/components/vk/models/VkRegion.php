<?php

namespace site\frontend\modules\geo2\components\vk\models;

/**
 * This is the model class for table "vk__regions".
 *
 * The followings are the available columns in table 'vk__regions':
 * @property string $id
 * @property string $countryId
 * @property string $title
 */
class VkRegion extends \CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vk__regions';
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
			'countryId' => 'Country',
			'title' => 'Title',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VkRegion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
