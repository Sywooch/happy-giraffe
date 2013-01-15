<?php

/**
 * This is the model class for table "routes__routes".
 *
 * The followings are the available columns in table 'routes__routes':
 * @property string $id
 * @property string $city_from_id
 * @property string $city_to_id
 *
 * The followings are the available model relations:
 * @property RouteLink[] $routesLinks
 * @property RouteLink[] $routesLinks1
 * @property GeoCity $city2
 * @property GeoCity $city1
 */
class Route extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Route the static model class
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
		return 'routes__routes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_from_id, city_to_id', 'required'),
			array('city_from_id, city_to_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, city_from_id, city_to_id', 'safe', 'on'=>'search'),
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
			'routesLinks' => array(self::HAS_MANY, 'RouteLink', 'route2_id'),
			'routesLinks1' => array(self::HAS_MANY, 'RouteLink', 'route1_id'),
			'city2' => array(self::BELONGS_TO, 'GeoCity', 'city_to_id'),
			'city1' => array(self::BELONGS_TO, 'GeoCity', 'city_from_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'city_from_id' => 'City1',
			'city_to_id' => 'City2',
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
		$criteria->compare('city_from_id',$this->city_from_id,true);
		$criteria->compare('city_to_id',$this->city_to_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}