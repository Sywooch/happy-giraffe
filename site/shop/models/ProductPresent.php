<?php

/**
 * This is the model class for table "shop__presents".
 *
 * The followings are the available columns in table 'shop__presents':
 * @property string $id
 * @property string $product_id
 * @property string $present_id
 * @property integer $count
 * @property integer $price
 *
 * The followings are the available model relations:
 * @property Product $present
 * @property Product $product
 */
class ProductPresent extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductPresent the static model class
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
		return 'shop__presents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('product_id, present_id', 'required'),
            array('count', 'numerical', 'integerOnly'=>true),
            array('product_id, present_id, price', 'length', 'max'=>10),
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
			'present' => array(self::BELONGS_TO, 'Product', 'present_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}
}