<?php

/**
 * This is the model class for table "{{product_attribute_value_map}}".
 *
 * The followings are the available columns in table '{{product_attribute_value_map}}':
 * @property string $map_id
 * @property string $map_attribute_id
 * @property string $map_value_id
 *
 * @property AttributeValue map_value
 */
class AttributeValueMap extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AttributeValueMap the static model class
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
		return 'shop__product_attribute_value_map';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('map_attribute_id, map_value_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('map_id, map_attribute_id, map_value_id', 'safe', 'on'=>'search'),
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
            'map_attribute' => array(self::BELONGS_TO, 'Attribute', 'map_attribute_id'),
            'map_value' => array(self::BELONGS_TO, 'AttributeValue', 'map_value_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'map_id' => 'Map',
			'map_attribute_id' => 'Map Attribute',
			'map_value_id' => 'Map Value',
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

		$criteria->compare('map_id',$this->map_id,true);
		$criteria->compare('map_attribute_id',$this->map_attribute_id,true);
		$criteria->compare('map_value_id',$this->map_value_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}