<?php

class EDZPMCityZone extends CActiveRecord {
	
	public function __construct($scenario = 'insert') {
		parent::__construct($scenario);
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function rules() {
		return array(
			
		);
	}
	
	public function getZoneByCityId() { 
		
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

}