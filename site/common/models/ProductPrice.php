<?php

/**
 * This is the model class for table "shop_product_price".
 *
 * The followings are the available columns in table 'shop_product_price':
 * @property integer $id
 * @property string $product_id
 * @property string $attribute_id
 * @property string $attribute_value_id
 * @property string $product_price
 * @property string $product_buy_price
 * @property string $product_sell_price
 */
class ProductPrice extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductPrice the static model class
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
		return 'shop__product_price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, attribute_id, attribute_value_id, product_price, product_buy_price, product_sell_price', 'required'),
			array('product_id, attribute_id, attribute_value_id, product_price, product_buy_price, product_sell_price', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, product_id, attribute_id, attribute_value_id, product_price, product_buy_price, product_sell_price', 'safe', 'on'=>'search'),
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
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'attribute' => array(self::BELONGS_TO, 'Attribute', 'attribute_id'),
            'attribute_value' => array(self::BELONGS_TO, 'AttributeValue', 'attribute_value_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'attribute_id' => 'Attribute',
			'attribute_value_id' => 'Attribute Value',
			'product_price' => 'Product Price',
			'product_buy_price' => 'Product Buy Price',
			'product_sell_price' => 'Product Sell Price',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('attribute_id',$this->attribute_id,true);
		$criteria->compare('attribute_value_id',$this->attribute_value_id,true);
		$criteria->compare('product_price',$this->product_price,true);
		$criteria->compare('product_buy_price',$this->product_buy_price,true);
		$criteria->compare('product_sell_price',$this->product_sell_price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}