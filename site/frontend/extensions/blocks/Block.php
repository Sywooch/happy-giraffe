<?php

class Block extends CComponent
{

	protected $url;
	protected $auto_refresh = 0;
	protected $data = array();
	
	public function __construct($params)
	{
		foreach ($params as $k => $v) $this->$k = $v;
	}

	public function generate()
	{
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if ($this->data)
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
		}
		
		$response = curl_exec($ch);
		curl_close($ch);
		
		die($response);
		
		return $response;
	}
	
}