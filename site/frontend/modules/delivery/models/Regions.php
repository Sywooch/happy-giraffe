<?php

/**
 * This is the model class for table "{{_Regions}}".
 *
 * The followings are the available columns in table '{{_Regions}}':
 * @property integer $region_id
 * @property integer $country_id
 * @property string $title
 */
class Regions extends HActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return Regions the static model class
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
		return 'shop_delivery_regions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('region_id, country_id', 'numerical', 'integerOnly' => true),
			array('title', 'length', 'max' => 255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('region_id, country_id, title', 'safe', 'on' => 'search'),
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
			'cities' => array(self::HAS_MANY, 'Cities', 'region_id'),
//			'country' => array(self::BELONGS_TO, 'Countries', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'region_id' => 'Region',
			'country_id' => 'Country',
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

		$criteria = new CDbCriteria;

		$criteria->compare('region_id', $this->region_id);
		$criteria->compare('country_id', $this->country_id);
		$criteria->compare('title', $this->title, true);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
			));
	}

	public function searchRegions()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('region_id', $this->region_id);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
			));
	}

	public function getRegions($country=1)
	{
		$vid = md5(__CLASS__ . __FUNCTION__ . $country);
		$value = Yii::app()->cache->get($vid);
		if(!$value)
		{
			$models = $this->findAll(($country) ? 'country_id=' . $country : null);
			$carr = array();
			foreach($models as $model)
				$carr[$model->region_id] = $model->title;
			asort($carr, SORT_STRING);
			$value = $carr;
			Yii::app()->cache->set($id, $value, 86400);
		}
		else
		{
			$value = "";
		}
		return $value;
	}

}