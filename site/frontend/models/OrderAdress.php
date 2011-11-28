<?php

/**
 * This is the model class for table "{{order_adress}}".
 *
 * The followings are the available columns in table '{{order_adress}}':
 * @property string $adress_id
 * @property string $adress_order_id
 * @property string $adress_index
 * @property string $adress_region_id
 * @property string $adress_city_id
 * @property string $adress_street
 * @property string $adress_house
 * @property string $adress_corps
 * @property string $adress_room
 * @property string $adress_porch
 * @property string $adress_floor
 */
class OrderAdress extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OrderAdress the static model class
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
		return '{{shop_order_adress}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('adress_order_id, adress_index, adress_region_id, adress_city_id, adress_street, adress_house', 'required', 'message'=>'Заполните поле "{attribute}"'),
			array('adress_order_id, adress_region_id, adress_city_id', 'length', 'max'=>10),
			array('adress_index, adress_house, adress_corps, adress_room, adress_porch, adress_floor', 'length', 'max'=>32),
			array('adress_street', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('adress_id, adress_order_id, adress_index, adress_region_id, adress_city_id, adress_street, adress_house, adress_corps, adress_room, adress_porch, adress_floor', 'safe', 'on'=>'search'),
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
			'adress_id' => 'Adress',
			'adress_order_id' => 'Adress Order',
			'adress_index' => 'Индекс',
			'adress_region_id' => 'Регион',
			'adress_city_id' => 'Город',
			'adress_street' => 'Улица',
			'adress_house' => 'Дом',
			'adress_corps' => 'Корпус',
			'adress_room' => 'Квартира',
			'adress_porch' => 'Подъезд',
			'adress_floor' => 'Этаж',
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

		$criteria->compare('adress_id',$this->adress_id,true);
		$criteria->compare('adress_order_id',$this->adress_order_id,true);
		$criteria->compare('adress_index',$this->adress_index,true);
		$criteria->compare('adress_region_id',$this->adress_region_id,true);
		$criteria->compare('adress_city_id',$this->adress_city_id,true);
		$criteria->compare('adress_street',$this->adress_street,true);
		$criteria->compare('adress_house',$this->adress_house,true);
		$criteria->compare('adress_corps',$this->adress_corps,true);
		$criteria->compare('adress_room',$this->adress_room,true);
		$criteria->compare('adress_porch',$this->adress_porch,true);
		$criteria->compare('adress_floor',$this->adress_floor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getAddressByOrderId($orderId) {
		$address = $this->find('adress_order_id = :adress_order_id', array(':adress_order_id' => $orderId));
		if ($address === null) {
			$address = new self();
		}
		return $address;
	}
}