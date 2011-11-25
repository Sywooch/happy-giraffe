<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
 
require_once dirname(dirname(__FILE__)).'/services/VKontakteOAuthService.php';

class CustomVKontakteService extends VKontakteOAuthService {	
	
	protected function fetchAttributes() {
		$info = (array)$this->makeSignedRequest('https://api.vkontakte.ru/method/getProfiles', array(
			'query' => array(
				'uids' => $this->getUid(),
				'fields' => 'photo',
			),
		));

		$info = $info['response'][0];

		$this->attributes['id'] = $info->uid;
		$this->attributes['first_name'] = $info->first_name;
		$this->attributes['photo'] = $info->photo;
	}
}
