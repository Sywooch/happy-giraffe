<?php

/**
 * This is the model class for table "shop__product_eav".
 *
 * The followings are the available columns in table 'shop__product_eav':
 * @property string $eav_id
 * @property string $eav_product_id
 * @property string $eav_attribute_id
 * @property string $eav_attribute_value
 *
 * The followings are the available model relations:
 * @property ShopProductAttribute $eavAttribute
 * @property ShopProduct $eavProduct
 */
class ShopProductEav extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ShopProductEav the static model class
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
		return 'shop__product_eav';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('eav_product_id, eav_attribute_id, eav_attribute_value', 'required'),
			array('eav_product_id, eav_attribute_id, eav_attribute_value', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('eav_id, eav_product_id, eav_attribute_id, eav_attribute_value', 'safe', 'on'=>'search'),
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
			'eavAttribute' => array(self::BELONGS_TO, 'ShopProductAttribute', 'eav_attribute_id'),
			'eavProduct' => array(self::BELONGS_TO, 'ShopProduct', 'eav_product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'eav_id' => 'Eav',
			'eav_product_id' => 'Eav Product',
			'eav_attribute_id' => 'Eav Attribute',
			'eav_attribute_value' => 'Eav Attribute Value',
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

		$criteria->compare('eav_id',$this->eav_id,true);
		$criteria->compare('eav_product_id',$this->eav_product_id,true);
		$criteria->compare('eav_attribute_id',$this->eav_attribute_id,true);
		$criteria->compare('eav_attribute_value',$this->eav_attribute_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}