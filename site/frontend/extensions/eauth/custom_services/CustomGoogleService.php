<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)).'/services/GoogleOpenIDService.php';

class CustomGoogleService extends GoogleOAuthService {
	
	//protected $jsArguments = array('popup' => array('width' => 450, 'height' => 450));
	
	protected $requiredAttributes = array(
		'name' => array('firstname', 'namePerson/first'),
		'lastname' => array('lastname', 'namePerson/last'),
		'email' => array('email', 'contact/email'),
		'language' => array('language', 'pref/language'),
	);
	
	protected function fetchAttributes() {
        $info = $this->makeSignedRequest('https://www.googleapis.com/oauth2/v1/userinfo');
        $this->attributes['id'] = $info->id;
        $this->attributes['name'] = $info->name;
        $this->attributes['url'] = $info->link;

        var_dump($info);
        Yii::app()->end();
	}
}