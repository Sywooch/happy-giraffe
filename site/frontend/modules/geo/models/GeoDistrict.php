<?php

/**
 * This is the model class for table "geo__district".
 *
 * The followings are the available columns in table 'geo__district':
 * @property string $id
 * @property string $name
 * @property string $region_id
 * @property string $capital_id
 * @property string $auto_created
 *
 * The followings are the available model relations:
 * @property GeoCity[] $geoCities
 * @property GeoCity $capital
 * @property GeoRegion $region
 */
class GeoDistrict extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GeoDistrict the static model class
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
		return 'geo__district';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>255),
			array('region_id, capital_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, region_id, capital_id', 'safe', 'on'=>'search'),
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
			'geoCities' => array(self::HAS_MANY, 'GeoCity', 'district_id'),
			'capital' => array(self::BELONGS_TO, 'GeoCity', 'capital_id'),
			'region' => array(self::BELONGS_TO, 'GeoRegion', 'region_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'region_id' => 'Region',
			'capital_id' => 'Capital',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('region_id',$this->region_id,true);
		$criteria->compare('capital_id',$this->capital_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}