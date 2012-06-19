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

        if(isset($info->first_name))
            $this->attributes['first_name'] = $info->first_name;
        else
            $this->attributes['first_name'] = $info->name;

        if(isset($info->last_name))
            $this->attributes['last_name'] = $info->last_name;

        if (isset($info->picture)){
            $temp_file_name = md5(microtime()).'.jpg';
            $img = AlbumPhoto::model()->getTempPath() . $temp_file_name;
            file_put_contents($img, file_get_contents($info->picture));

            $this->attributes['photo'] = AlbumPhoto::model()->getTempUrl().$temp_file_name;

            $image = new Image(AlbumPhoto::model()->getTempPath().$temp_file_name);
            $image->resize(80, 80);
            $image->save();

            $this->attributes['avatar'] = $info->picture;
        }

//        ["id"]=> string(21) "108255744559712996341"
//        ["name"]=> string(11) "Alex Kireev"
//        ["given_name"]=> string(4) "Alex"
//        ["family_name"]=> string(6) "Kireev"
//        ["link"]=> string(45) "https://plus.google.com/108255744559712996341"
//        ["picture"]=> string(92) "https://lh6.googleusercontent.com/-n6T6SBs7P2g/AAAAAAAAAAI/AAAAAAAAElY/ofSrn_3TftM/photo.jpg"
//        ["gender"]=> string(4) "male"
//        ["locale"]=> string(2) "en" }
	}
}