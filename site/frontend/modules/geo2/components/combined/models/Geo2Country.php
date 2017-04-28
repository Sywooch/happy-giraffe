<?php

namespace site\frontend\modules\geo2\components\combined\models;

/**
 * This is the model class for table "geo2__country".
 *
 * The followings are the available columns in table 'geo2__country':
 * @property string $id
 * @property string $title
 * @property string $iso
 * @property string $vkId
 */
class Geo2Country extends \CActiveRecord implements \IHToJSON
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'geo2__country';
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
			'vkId' => 'Vk',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Geo2Country the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @return array
     */
	public function toJSON()
    {
        return $this->getAttributes();
    }

    public function iso($value)
	{
		$this->getDbCriteria()->compare('iso', $value);
		return $this;
	}
}
