<?php

/**
 * This is the model class for table "shop_order_item".
 *
 * The followings are the available columns in table 'shop_order_item':
 * @property string $item_id
 * @property string $item_order_id
 * @property string $item_product_id
 * @property string $item_product_count
 * @property string $item_product_cost
 * @property string $item_product_title
 * @property string $item_product_property
 */
class OrderItem extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OrderItem the static model class
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
		return 'shop__order_item';
	}
	
	/**
	 * @return string primary key of the table
	 */
	public function primaryKey() {
		return 'item_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_order_id, item_product_id, item_product_count, item_product_cost, item_product_title', 'required'),
			array('item_order_id, item_product_id, item_product_count', 'length', 'max'=>10),
			array('item_product_cost', 'length', 'max'=>12),
			array('item_product_title', 'length', 'max'=>250),
			array('item_product_property', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('item_id, item_order_id, item_product_id, item_product_count, item_product_cost, item_product_title, item_product_property', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'product' => array(self::BELONGS_TO, 'Product', 'item_product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'item_id' => 'Item',
			'item_order_id' => 'Item Order',
			'item_product_id' => 'Item Product',
			'item_product_count' => 'Item Product Count',
			'item_product_cost' => 'Item Product Cost',
			'item_product_title' => 'Item Product Title',
			'item_product_property' => 'Item Product Property',
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

		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('item_order_id',$this->item_order_id,true);
		$criteria->compare('item_product_id',$this->item_product_id,true);
		$criteria->compare('item_product_count',$this->item_product_count,true);
		$criteria->compare('item_product_cost',$this->item_product_cost,true);
		$criteria->compare('item_product_title',$this->item_product_title,true);
		$criteria->compare('item_product_property',$this->item_product_property,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}