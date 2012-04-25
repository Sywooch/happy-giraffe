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
class OrderAdress extends HActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return OrderAdress the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'shop__order_adress';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('adress_order_id, adress_index, adress_region_id, adress_city_id, adress_street, adress_house', 'required', 'message' => 'Заполните поле "{attribute}"'),
			array('adress_order_id, adress_region_id, adress_city_id', 'length', 'max' => 10),
			array('adress_index, adress_house, adress_corps, adress_room, adress_porch, adress_floor', 'length', 'max' => 32),
			array('adress_street', 'length', 'max' => 250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('adress_id, adress_order_id, adress_index, adress_region_id, adress_city_id, adress_street, adress_house, adress_corps, adress_room, adress_porch, adress_floor', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
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
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('adress_id', $this->adress_id, true);
		$criteria->compare('adress_order_id', $this->adress_order_id, true);
		$criteria->compare('adress_index', $this->adress_index, true);
		$criteria->compare('adress_region_id', $this->adress_region_id, true);
		$criteria->compare('adress_city_id', $this->adress_city_id, true);
		$criteria->compare('adress_street', $this->adress_street, true);
		$criteria->compare('adress_house', $this->adress_house, true);
		$criteria->compare('adress_corps', $this->adress_corps, true);
		$criteria->compare('adress_room', $this->adress_room, true);
		$criteria->compare('adress_porch', $this->adress_porch, true);
		$criteria->compare('adress_floor', $this->adress_floor, true);

		return new CActiveDataProvider($this, array(
					'criteria' => $criteria,
				));
	}

	/**
	 * Get address of order $orderId
	 * @param int $orderId
	 * @return OrderAdress 
	 */
	public function getOrderAddress($orderId) {
		$address = $this->find('adress_order_id = :adress_order_id', array(':adress_order_id' => $orderId));
		if ($address === null) {
			$address = new self();
		}
		return $address;
	}

	/**
	 * Get full order address of order $orderId
	 * and format it.
	 * @param int $orderId 
	 * @return string formatted address
	 */
	public function getFormattedOrderAddress($orderId) {
		$select = '
			adress_index, adress_street, 
			adress_house, adress_corps, 
			adress_room, adress_porch, 
			adress_floor, geo_rus_region.name AS region_name, 
			geo_rus_settlement.name AS city_name
		';
		$command = Y::command()
				->select($select)
				->from(self::model()->tableName())
				->where('adress_order_id = :adress_order_id', array(
					':adress_order_id' => $orderId,
				))
				->leftJoin('geo_rus_region', 'geo_rus_region.id = adress_region_id')
				->leftJoin('geo_rus_settlement', 'geo_rus_settlement.id = adress_city_id')
				->order('adress_id DESC');
		return $this->formatAddress($command->queryRow());
	}

	/**
	 * Format address
	 * @param array $address
	 * @return string formatted address 
	 */
	protected function formatAddress(array $address) {
		$chunks = array();
		$part = '';
		if (isset($address['adress_index']) && $address['adress_index'] != 'Индекс') {
			$chunks[] = $address['adress_index'];
		}
		if (isset($address['region_name']) && $address['region_name'] != 'Регион') {
			$chunks[] = $address['region_name'];
		}
		$part .= implode(', ', $chunks);
		$part .= CHtml::tag('br');
		$chunks = array();
		if (isset($address['city_name']) && $address['city_name'] != 'Нас. пункт') {
			$chunks[] = 'г. ' . $address['city_name'];
		}
		if (isset($address['adress_street']) && $address['adress_street'] != 'Улица') {
			$chunks[] = 'ул. ' . $address['adress_street'];
		}
		if (isset($address['adress_house']) && $address['adress_house'] != '№ дома') {
			$chunks[] = 'д. ' . $address['adress_house'];
		}
		if (isset($address['adress_corps']) && $address['adress_corps'] != 'Стр. / корп.') {
			$chunks[] = 'корп. ' . $address['adress_corps'];
		}
		if (isset($address['adress_room']) && $address['adress_room'] != '№ квартиры') {
			$chunks[] = 'кв. ' . $address['adress_room'];
		}
		if (sizeof($chunks) > 0) {
			$part .= implode(', ', $chunks);
		}
		$chunks = array();
		if (isset($address['adress_porch']) || isset($address['adress_floor'])) {
			if ($address['adress_porch'] != 'Подъезд') {
				$chunks[] = $address['adress_porch'] . ' подъезд';
			}
			if ($address['adress_floor'] != 'Этаж') {
				$chunks[] = $address['adress_floor'] . ' этаж';
			}
			if (sizeof($chunks) > 0) {
				$part .= ', ' . CHtml::openTag('span');
				$part .= implode(', ', $chunks);
				$part .= CHtml::closeTag('span');
			}
		}
		return $part;
	}
}