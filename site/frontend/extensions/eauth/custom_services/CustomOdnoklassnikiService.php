<?php
/**
 * CustomOdnoklassnikiService class file.
 *
 * @author Sergey Vardanyan <rakot.ss@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)).'/services/OdnoklassnikiOAuthService.php';

class CustomOdnoklassnikiService extends OdnoklassnikiOAuthService {

    protected $scope = 'VALUABLE ACCESS';

    protected function fetchAttributes() {
        parent::fetchAttributes();
        if ($this->scope == 'VALUABLE ACCESS')
            $this->getRealIdAndUrl();
    }

    /**
     * Avable only if VALUABLE ACCESS is on
     * you should ask for enable this scope for odnoklassniki administration
     */
    protected function getRealIdAndUrl() {
        $sig = strtolower(md5('application_key='.$this->client_public.'client_id='.$this->client_id.'format=JSONmethod=users.getCurrentUser'.md5($this->access_token.$this->client_secret)));

        $info = $this->makeRequest('http://api.odnoklassniki.ru/fb.do', array(
            'query' => array(
                'method' => 'users.getCurrentUser',
                'sig' => $sig,
                'format' => 'JSON',
                'application_key' => $this->client_public,
                'client_id' => $this->client_id,
                'access_token' => $this->access_token,
            ),
        ));

        $this->attributes['id'] = $info->uid;
        $this->attributes['name'] = $info->first_name.' '.$info->last_name;
        $this->attributes['first_name'] = $info->first_name;
        $this->attributes['last_name'] = $info->last_name;
        if (isset($info->birthday))
            $this->attributes['birthday'] = $info->birthday;

        if (isset($info->pic_1)){
            $temp_file_name = md5(microtime()).'.jpeg';
            $img = AlbumPhoto::model()->getTempPath() . $temp_file_name;
            file_put_contents($img, file_get_contents($info->pic_1));

            $this->attributes['photo'] = AlbumPhoto::model()->getTempUrl().$temp_file_name;

            $this->attributes['avatar'] = str_replace('&photoType=4', '', $info->pic_1);
        }
    }
}