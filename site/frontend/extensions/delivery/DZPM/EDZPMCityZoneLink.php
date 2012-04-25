<?php

/**
 * This class represents table `shop_delivery_edzpm_city_zone_link` in database
 * @property $id
 * @property $city_id
 * @property @edzpm_zone_id
 */
class EDZPMCityZoneLink extends CActiveRecord {

	public function __construct($scenario = 'insert') {
		parent::__construct($scenario);
	}

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function primaryKey() {
		return 'id';
	}
	
	public function tableName() {
		return 'shop_delivery_edzpm_city_zone_link';
	}

	public function rules() {
		return array(
			array('city_id, edzpm_zone_id', 'required'),
			array('id, city_id, edzpm_zone_id', 'numerical', 'integerOnly' => true),
			array('id, city_id, edzpm_zone_id', 'safe'),
		);
	}

	public function getForm() {
		$params = array(
			'type' => 'form',
			'elements' => array(
				'city' => array(
					'type' => 'hidden',
				),
			),
		);

		return new CForm($params, $this);
	}
	
	/**
	 * Return zone id by $cityId
	 * @param type $cityId 
	 * @return int
	 */
	public function getZoneByCityId($cityId) {
		$ct = new CDbCriteria();
		$ct->addCondition('city_id = :city_id');
		$ct->params = array(
			':city_id' => $cityId
		);
		$cityZoneLink = $this->find($ct);
		if (!$cityZoneLink) {
			return null;
		}
		return $cityZoneLink->edzpm_zone_id;
	}
}