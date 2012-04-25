<?php

/**
 * This class represents table 'shop_delivery_egruzovozofftarif'
 * @property $id
 * @property $city
 * @property $price
 */
class EGruzovozoffTarif extends CActiveRecord {

	public $createTable = true;

	public function __construct($scenario='insert') {
		parent::__construct($scenario);
	}

	public function rules() {
		return array(
			array('id', 'numerical', 'integerOnly' => true),
			array('city', 'required'),
			array('id, city, price', 'safe'),
		);
	}

	public function primaryKey() {
		return 'id';
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return Delivery the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'shop_delivery_egruzovozofftarif';
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'price' => 'Цена',
			'city' => 'Город'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('price', $this->price, true);
		$criteria->compare('city', $this->city, true);

		return new CActiveDataProvider(get_class($this), array(
					'criteria' => $criteria,
				));
	}

	/**
	 * Get costs by order cities
	 * @param array $citites 
	 * @return array
	 */
	public function getCosts($citites) {
		$prices = array();
		$k = 0;
        /*
         * @todo change this
         */
		$products = Yii::app()->shoppingCart->getPositions();
		foreach ($citites as $city) {
			$price = 0;
			foreach ($products as $product) {
				$dimensions = array(
					'length' => $product->length,
					'width' => $product->width,
					'height' => $product->height,
					'weight' => $product->weight
				);
				$tarif = $this->getTarif($city, $dimensions);
				if (isset($tarif['city']) && isset($tarif['price'])) {
					$price += $tarif['price'];
				}
			}
			$prices[$k]['price'] = $price;
			$prices[$k]['destination'] = $city;
			$k++;
		}
		return $prices;
	}

	/**
	 *
	 * @param type $city
	 * @param array $dimensions {@see getCost()}
	 * @return string
	 */
	protected function getTarif($city, array $dimensions) {
		$postData = 'start_city_id=' . $this->getGffFromCityId();
		$postData .= '&finish_city_id=' . $this->getGffCityToId($city);
		$length = (isset($dimensions['length']) && $dimensions['length']) ? $dimensions['length'] : 1;
		$postData .= '&length=' . $length;
		$width = (isset($dimensions['width']) && $dimensions['width']) ? $dimensions['width'] : 1;
		$postData .= '&width=' . $width;
		$height = (isset($dimensions['height']) && $dimensions['height']) ? $dimensions['height'] : 1;
		$postData .= '&height=' . $height;
		$weight = (isset($dimensions['weight']) && $dimensions['weight']) ? $dimensions['weight'] : 1;
		$postData .= '&weight=' . $weight;
		$postData .= '&qty=1';
		$postData .= '&mode=addrate';
		$gffPageData = $this->makeRequest($postData);
		$pattern = "#<TD ALIGN=RIGHT VALIGN=MIDDLE CLASS=RATES_TABLE>([^<]+)<\/TD>#";
		preg_match($pattern, $gffPageData, $matches);
		$price = (int) $matches[1];
		if ($price) {
			return array('city' => $city, 'price' => $price);
		}
		return array();
	}

	/**
	 * Make post request to gruzovozoff.ru
	 * @return string
	 */
	protected function makeRequest($postData) {
		$url = 'http://www.gruzovozoff.ru/rus/engine.php';
		// The submitted form data, encoded as query-string-style
		// name-value pairs
		$c = curl_init($url);
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($c, CURLOPT_COOKIEFILE, Yii::app()->getRuntimePath() . '/cookie.txt');
		$page = curl_exec($c);
		curl_close($c);
		return $page;
	}

	/**
	 * Get gruzovozoff finish_city_id by
	 * @param string $name
	 * @return array|false
	 */
	protected function getGffCityToId($name) {
        $cities = require dirname(__FILE__) . '/cities.php';
		$c = array_flip($cities);
		return isset($c[$name]) ? $c[$name] : false;
	}

	/**
	 * Get gruzovozoff start_city_id.
	 * In our case is id of Moscow
	 * @return string
	 */
	protected function getGffFromCityId() {
		return '0a7e43f275ddce744b13b8e1cea2f5a3';
	}

}

?>