<?php

class SocialController extends HController
{
	public $regdata;

	public function actionVk()
	{
		if ($_REQUEST['hash'] === md5(Yii::app()->params['social']['vk']['api_id'] . $_REQUEST['uid'] . Yii::app()->params['social']['vk']['secret_key']))
		{
			$this->regdata = array(
				'provider' => 'vk',
				'first_name' => $_REQUEST['first_name'],
				'uid' => $_REQUEST['uid'],
				'pic' => $_REQUEST['photo_rec'],
			);
		}
	}
	
	public function actionMail()
	{
		parse_str(urldecode($_COOKIE['mrc']),$array);
		

		if ($this->sign_server_server($array,Yii::app()->params['social']['mail']['secret_key'])==$array['sig'])
		{
			$params = array(
				"method"=>"users.getInfo",
				"app_id"=>Yii::app()->params['social']['mail']['api_id'],
				"session_key"=>$array['session_key'],
				"uids"=>$array['vid'],
				"secure"=>"1"
			);

			$url = "http://www.appsmail.ru/platform/api?".http_build_query($params)."&sig=".$this->sign_server_server($params,Yii::app()->params['social']['mail']['secret_key']);
			
			$response = json_decode(file_get_contents($url));
			
			$this->regdata = array(
				'provider' => 'mail',
				'first_name' => $response[0]->first_name,
				'uid' => $response[0]->uid,
				'pic' => $response[0]->pic,
			);
		}
	}
	
	public function actionOdnoklassniki()
	{
		
	}
	
	function sign_client_server(array $request_params, $uid, $private_key) {
		ksort($request_params);
		$params = '';
		foreach ($request_params as $key => $value) {
			$params .= "$key=$value";
		}
		return md5($uid . $params . $private_key);
	}

	function sign_server_server(array $request_params, $secret_key) {
		ksort($request_params);
		$params = '';
		foreach ($request_params as $key => $value) {
			if ($key!='sig') {
				$params .= "$key=$value";
			}
		}
		return md5($params . $secret_key);
	}
	
	public function afterAction($action)
	{
	
		Yii::app()->session['regdata'] = $this->regdata;
		$this->redirect(array('site/register'));
	}
	
}