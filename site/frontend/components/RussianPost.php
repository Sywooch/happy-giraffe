<?php

class RussianPost extends CComponent
{
	private $delay = 100;
	private $types = array(
		'region' => '-1',
		'district' => '5',
		'settlement' => '6',
		'street' => '8',
	);	
	private $link = 'http://www.russianpost.ru/PostOfficeFindInterface/AddressComparison.asmx/GetDataFilter?';
	
	private $proxy_list = array(
		'66.232.117.100:60099',
		'66.232.117.102:60099',
		'66.232.117.103:60099',
		'66.232.117.104:60099',
		'66.232.117.147:60099',
		'208.115.216.238:60099',
		'208.115.216.240:60099',
		'208.115.216.241:60099',
		'208.115.216.242:60099',
		'208.115.216.209:60099',
	);
	private $proxy_current = 0;

	public function update()
	{
		echo 'Started on ' . date ('d.m.Y H:i:s') . '.' . "\n";
		Yii::app()->db->createCommand()->truncateTable('geo_rus_region');
		Yii::app()->db->createCommand()->truncateTable('geo_rus_district');
		Yii::app()->db->createCommand()->truncateTable('geo_rus_settlement');
		Yii::app()->db->createCommand()->truncateTable('geo_rus_street');
		$regions = $this->_fetch('-1');
		foreach ($regions as $region_id => $region_name)
		{
			$s = time();
			echo 'Parsing of ' . $region_name . ' started at ' . date('H:i:s') . '.' . "\n";
			$region = new GeoRusRegion;
			$region->name = $region_name;
			$region->save();
			
			$settlements = $this->_fetch($region_id, 'settlement');
			$_settlements = array();
			foreach ($settlements as $settlement_id => $settlement_name)
			{
				$settlement = new GeoRusSettlement;
				$settlement->name = $settlement_name;
				$settlement->region_id = $region->id;
				$_settlements[$settlement_id] = $settlement;
			}
			
			$districts = $this->_fetch($region_id, 'district');
			foreach ($districts as $district_id => $district_name)
			{
				$district = new GeoRusDistrict;
				$district->name = $district_name;
				$district->region_id = $region->id;
				$district->save();
				
				$settlements = $this->_fetch($district_id, 'settlement');
				foreach ($settlements as $settlement_id => $settlement_name)
				{
					$_settlements[$settlement_id]->district_id = $district->id;
				}
			}
			
			foreach ($_settlements as $settlement_id => $settlement)
			{
				$settlement->save();
				$streets = $this->_fetch($settlement_id, 'street');
				foreach ($streets as $street_id => $street_name)
				{
					$street = new GeoRusStreet;
					$street->name = $street_name;
					$street->settlement_id = $settlement->id;
					$street->save();
				}
			}
			echo 'Parsing finished within ' . time() - $s . ' seconds.' . "\n";
		}
		echo 'Finished on ' . date ('d.m.Y H:i:s') . '.' . "\n";
	}
		
	private function _fetch($parent_id, $child_type = 'region')
	{
		$child_type = $this->types[$child_type];
		$params = array(
			'ParentId' => $parent_id,
			'ChildType' => $child_type,
		);
		$url = $this->link . Yii::app()->getUrlManager()->createPathInfo($params, '=', '&');
		
		$ch = curl_init();
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_PROXY => $this->proxy_list[$this->proxy_current++ % 10],
			CURLOPT_PROXYUSERPWD => 'solivager:K5UrR5UeC7sEsJT',
		);
		curl_setopt_array($ch, $options);
		do
		{
			$response = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$result = $response && $http_code == 200;
		} while ($result === FALSE);
		curl_close($ch);
		
		$response = preg_replace('/"Value":(\d+)/','"Value":"$1"', $response);
		$json = CJSON::decode($response);
		array_shift($json);
		$output = array();	
		foreach ($json as $r)
		{
			$output[$r['Value']] = $r['Text'];
		}	
		
		usleep($this->delay);
		return $output;
	}
	
}