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

        $sig = strtolower(md5('application_key=' . $this->client_public . 'client_id=' . $this->client_id . 'format=JSONmethod=users.getCurrentUser' . md5($this->access_token . $this->client_secret)));

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
        $this->attributes['name'] = $info->first_name . ' ' . $info->last_name;
        $this->attributes['gender'] = $info->gender == 'male' ? 1 : 0;
        $this->attributes['first_name'] = $info->first_name;
        $this->attributes['last_name'] = $info->last_name;
        if (isset($info->birthday))
            $this->attributes['birthday'] = $info->birthday;

        if (isset($info->pic_1)) {
            $temp_file_name = md5(microtime()) . '.jpeg';
            $img = AlbumPhoto::model()->getTempPath() . $temp_file_name;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $info->pic_1);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            $data = curl_exec($ch);
            curl_close($ch);

            if ($data) {
                file_put_contents($img, $data);
                $this->attributes['photo'] = AlbumPhoto::model()->getTempUrl() . $temp_file_name;
                $this->attributes['avatar'] = str_replace('&photoType=4', '', $info->pic_1);
            }
        }
    }
    
    public function wallPost($data)
    {
        $post = array(
            'application_key'=> $this->client_public,
            'method' => 'share.addLink',
            'format' => 'JSON',
        );
        if(isset($data['link']))
        {
            $post['linkUrl'] = $data['link'];
        }

        if(isset($data['message']))
        {
            $post['comment'] = $data['message'];
        }
        $this->makeSignedRequest('http://api.odnoklassniki.ru/fb.do',array(
            'query'=>$post
        ));
    }

}
