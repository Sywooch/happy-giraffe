<?php

namespace site\frontend\modules\geo2\components\combined\models;

/**
 * This is the model class for table "geo2__region".
 *
 * The followings are the available columns in table 'geo2__region':
 * @property string $id
 * @property string $countryId
 * @property string $title
 * @property integer $vkId
 * @property integer $fiasId
 */
class Geo2Region extends \CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'geo2__region';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'country' => array(self::BELONGS_TO, 'site\frontend\modules\geo2\components\combined\models\Geo2Country', 'countryId'),
		];
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
			'vkId' => 'Vk',
			'fiasId' => 'Fias',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Geo2Region the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
