<?php

class GeoController extends Controller
{

	public function filters()
	{
		return array(
			'accessControl', 
		);
	}
	
	public function accessRules()
	{
		return array(
			array('allow',  
				'actions'=>array('convert'),
				'ips'=>array('127.0.0.1'),
			),
			array('deny',
				'actions'=>array('convert'),
			),
		);
	}
	
	public function actionConvert()
	{
		set_time_limit(0);
	
		$types = GeoRusSettlementType::model()->findAll();
		$_types = array();
		foreach ($types as $t) $_types[$t->id] = $t->short_name;

		$limit = 5000;
		$count = GeoRusSettlement::model()->count();
		for ($i = 0; $i < ceil($count/$limit); $i++)
		{
			$settlements = GeoRusSettlement::model()->findAll(array(
				'limit' => $limit,
				'offset' => $i * $limit,
				'order' => 'id ASC',
			));
		
			foreach ($settlements as $s)
			{
				if (preg_match('/^(.+) (г\.|д\.|с\.|п\.)$/', $s->name, $matches))
				{
					$type_short_name = $matches[2];
					$type_id = array_search($type_short_name, $_types);
					$name = $matches[1];
					$s->name = $name;
					$s->type_id = $type_id;
				}
				else
				{
					$s->type_id = NULL;
				}
				$s->save();
			}
		}
	}

}
