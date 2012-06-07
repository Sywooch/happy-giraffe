<?php

/**
 * This is the model class for table "{{_Cities}}".
 *
 * The followings are the available columns in table '{{_Cities}}':
 * @property integer $city_id
 * @property integer $country_id
 * @property integer $region_id
 * @property string $title
 */
class Cities extends HActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return Cities the static model class
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
		return 'shop_delivery_cities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_id, country_id, region_id', 'numerical', 'integerOnly' => true),
			array('title', 'length', 'max' => 255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('city_id, country_id, region_id, title', 'safe', 'on' => 'search'),
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
			'region' => array(self::BELONGS_TO, 'Regions', 'region_id'),
			'cityreg1' => array(self::BELONGS_TO, 'Cities', 'city_regional1_id'),
			'cityreg2' => array(self::BELONGS_TO, 'Cities', 'city_regional2_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'city_id' => 'City',
			'country_id' => 'Country',
			'region_id' => 'Region',
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

		$criteria->compare('city_id', $this->city_id);
		$criteria->compare('country_id', $this->country_id);
		$criteria->compare('region_id', $this->region_id);
		$criteria->compare('title', $this->title, true);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
			));
	}

	public function getCities($region=null)
	{
		$vid = md5(__CLASS__ . __FUNCTION__ . $region);
		$value = Yii::app()->cache->get($vid);
		if(!$value)
		{
			$carr = array();
			if($region)
			{
				$models = $this->findAll(($region) ? 'region_id=' . $region : null);

				foreach($models as $model)
					$carr[$model->city_id] = $model->title;
				asort($carr, SORT_STRING);
			}
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