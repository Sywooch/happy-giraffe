<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class VkontakteComponent extends CComponent
{

	public function checkSession(){
		parse_str(urldecode($_COOKIE['vk_app_2419018']), $mrcArray);
		$sign = '';
		foreach ($mrcArray as $key => $value) {
			if ($key != 'sig') {
				$sign .= ($key.'='.$value);
			}
		}
		$sign .= 'cwycfuDBH0u19H8FOzB9';
		$sign = md5($sign);
		if ($mrcArray['sig'] == $sign && $mrcArray['expire'] > time()) {
			return true;
		}
		return false;
	}

	public function getProfile($id)
	{
		$vk = new Vkapi(2419018, 'cwycfuDBH0u19H8FOzB9');
		$arr = $vk->api('getProfiles', array(
			'uids' => $id,
			'fields' => 'nickname,city,country,photo_medium',
		));
		$profile = array();
		$profile['vk_id'] = $arr['response'][0]['uid'];
		$profile['nick'] = $arr['response'][0]['nickname'];
		$profile['first_name'] = $arr['response'][0]['first_name'];
		$profile['last_name'] = $arr['response'][0]['last_name'];
		if (empty($profile['nick']))
			$profile['nick'] = $profile['first_name'].' '.$profile['last_name'];
		$profile['avatar'] = $arr['response'][0]['photo_medium'];
		$profile['link'] = 'http://vkontakte.ru/id'.$profile['vk_id'];
		return $profile;
	}

}