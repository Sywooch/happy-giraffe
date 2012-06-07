<?php

/**
 * This is the model class for table "{{order}}".
 *
 * The followings are the available columns in table '{{order}}':
 * @property string $order_id
 * @property integer $order_status
 * @property integer $order_payed
 * @property string $order_time
 * @property string $order_user_id
 * @property string $order_item_count
 * @property string $order_price
 * @property string $order_price_total
 * @property string $order_price_delivery
 * @property string $order_width
 * @property string $order_volume
 * @property string $order_delivery_adress
 * @property string $order_description
 * @property string $order_vaucher_id
 */
class Order extends HActiveRecord
{
	const ORDER_STATUS_CANCEL = -1;
	const ORDER_STATUS_INIT = 0;
	const ORDER_STATUS_NEW = 1;
	const ORDER_STATUS_PROCEED = 2;
	const ORDER_STATUS_SHIPPED = 3;
	const ORDER_STATUS_DELIVERED = 4;
//	const ORDER_STATUS_COMPITED = 5;

	public function behaviors()
	{
		return array(
			'statuses' => array(
				'class' => 'ext.status.EStatusBehavior',
				// Поле зарезервированное для статуса
				'statusField' => 'order_status',
				'statuses' => array(
					self::ORDER_STATUS_CANCEL => 'Cancel',
					self::ORDER_STATUS_INIT => 'Init',
					self::ORDER_STATUS_NEW => 'New',
					self::ORDER_STATUS_PROCEED => 'Proceed',
					self::ORDER_STATUS_SHIPPED => 'Shipped',
					self::ORDER_STATUS_DELIVERED => 'Delivered',
//					self::ORDER_STATUS_COMPITED => 'Complited',
				),
			),
		);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @return Order the static model class
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
		return 'shop__order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_item_count, order_price, order_price_total, order_width, order_volume', 'required'),
			array('order_status, order_payed', 'numerical', 'integerOnly'=>true),
			array('order_price, order_price_total, order_price_delivery', 'numerical'),
			array('order_time, order_user_id, order_item_count, order_vaucher_id', 'length', 'max'=>10),
			array('order_price, order_price_total, order_price_delivery, order_width, order_volume', 'length', 'max'=>12),
			array('order_description, order_delivery_adress', 'safe'),
			
			array('order_description','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			
			array('order_time', 'default', 'value' => time()),
			array('order_user_id', 'default', 'value' => Y::userId()),
			array('order_status', 'default', 'value' => 1),
			array('order_price_delivery', 'default', 'value' => 0),
			array('order_payed', 'default', 'value' => 0),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('order_id, order_status, order_payed, order_time, order_user_id, order_item_count, order_price, order_price_total, order_price_delivery, order_width, order_volume, order_delivery_adress, order_description, order_vaucher_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_id' => 'Order',
			'order_status' => 'Статус',
			'order_payed' => 'Оплачен?',
			'order_time' => 'Дата создания',
			'order_user_id' => 'Пользователь',
			'order_item_count' => 'Кол-во продуктов',
			'order_price' => 'Стоимость',
			'order_price_total' => 'Стоимость со скидкой',
			'order_price_delivery' => 'Стоимость доставки',
			'order_width' => 'Вес',
			'order_volume' => 'Объем',
			'order_delivery_adress' => 'Адрес доставки',
			'order_description' => 'Описание',
			'order_vaucher_id' => 'Ваучер',
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

		$criteria->compare('order_id',$this->order_id);
		
		if(is_null($this->order_status))
			$this->order_status = self::ORDER_STATUS_PROCEED;
		
		$criteria->compare('order_status',$this->order_status);
		$criteria->compare('order_payed',$this->order_payed);
		$criteria->compare('order_time',$this->order_time,true);
		$criteria->compare('order_user_id',$this->order_user_id);
		$criteria->compare('order_item_count',$this->order_item_count);
		$criteria->compare('order_price',$this->order_price);
		$criteria->compare('order_price_total',$this->order_price_total);
		$criteria->compare('order_price_delivery',$this->order_price_delivery);
		$criteria->compare('order_width',$this->order_width,true);
		$criteria->compare('order_volume',$this->order_volume,true);
		$criteria->compare('order_delivery_adress',$this->order_delivery_adress,true);
		$criteria->compare('order_description',$this->order_description,true);
		$criteria->compare('order_vaucher_id',$this->order_vaucher_id,true);
		
		if(!isset($_GET['Order_sort']))
			$criteria->order = 'order_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeValidate()
	{
		if($this->getIsNewRecord() && ShopCart::isEmpty())
		{
			$this->addError('order_description', 'Shopping Cart is empty');
			return false;
		}
		
		$this->order_item_count = ShopCart::getItemsCount();
		$this->order_price = ShopCart::getCost(false);
		$this->order_price_total = ShopCart::getCost(true);
		
		/**
		 * @todo calculate width and volume
		 */
		$this->order_width = 1;
		$this->order_volume = 1;
		
		if(Y::user()->hasFlash('vaucher'))
		{
			$vaucher = Y::user()->getFlash('vaucher');
			$this->order_vaucher_id = $vaucher['vaucher_id'];
		}
		
		return parent::beforeValidate();
	}
	
	public function afterSave()
	{
		foreach(ShopCart::getItems() as $position)
		{
            $product = Product::model()->findByPk($position->id);
			$property = $product->getAttributesText();

			Y::command()
				->insert('shop_order_item', array(
					'item_order_id' => $this->order_id,
					'item_product_id' => $product->product_id,
					'item_product_count' => $position->count,
					'item_product_cost' => $product->getPrice(),
					'item_product_title' => $product->product_title,
					'item_product_property' => CJSON::encode($property),
				));
		}

		parent::afterSave();
	}
	
	public function getPrice()
	{
		return $this->order_price_total;
	}
	
	public function getWeight()
	{
		return $this->order_width;
	}
	
	public function getVolume()
	{
		return $this->order_volume;
	}
	
	public function getCountry()
	{
		/**
		 * @todo real country
		 */
		return 'Россия';
	}
	
	public function getRegion()
	{
		/**
		 * @todo real region
		 */
		return 42;
	}
	
	public function getCity()
	{
		return Y::user()->hasState('settlement_id') ? Y::user()->getState('settlement_id') : null;
	}
	
	public function getAdress()
	{
		/**
		 * @todo real adress
		 */
		return 'Адресс';
	}
	
	public static function callbackOrderProceed(BillingInvoice $invoce)
	{
		$order = self::model()->findByPk($invoce->invoice_order_id);
		if(!$order) {
			return;
		}
		self::model()->updateByPk($order->order_id, array('order_status' => self::ORDER_STATUS_PROCEED));
	}
	
	public static function callbackOrderPaid(BillingInvoice $invoce)
	{
		$order = self::model()->findByPk($invoce->invoice_order_id);
		if(!$order) {
			return;
		}
		self::model()->updateByPk($order->order_id, array('order_payed' => 1));
	}
	
	public function primaryKey() {
		return 'order_id';
	}
}