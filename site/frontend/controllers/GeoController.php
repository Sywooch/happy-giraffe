<?php

class GeoController extends Controller
{
	public function actionCountries()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$countries = GeoCountry::model()->findAll(array(
				'condition' => 'name LIKE :term',
				'params' => array(':term' => $_GET['term'] . '%'),
			));
			
			$_countries = array();
			foreach ($countries as $country)
			{
				$_countries[] = array(
					'label' => $country->name,
					'value' => $country->name,
					'id' => $country->id,
				);
			}
			echo CJSON::encode($_countries);
		}
	}
	
	public function actionCities()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$cities = GeoCity::model()->findAll(array(
				'condition' => 'name LIKE :term AND country_id = :country_id',
				'params' => array(':term' => $_GET['term'] . '%', ':country_id' => $_GET['country_id']),
			));
			
			
			
			$_cities = array();
			foreach ($cities as $city)
			{
				$_cities[] = array(
					'label' => $city->name,
					'value' => $city->name,
					'id' => $city->id,
				);
			}
			echo CJSON::encode($_cities);
		}
	}
}
