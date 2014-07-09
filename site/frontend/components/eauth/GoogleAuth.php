<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 09/07/14
 * Time: 14:49
 */

class GoogleAuth extends GoogleOAuthService
{
    protected $name = 'google';

    protected function fetchAttributes()
    {
        $info = (array)$this->makeSignedRequest('https://www.googleapis.com/oauth2/v1/userinfo');
        $this->attributes['uid'] = $info['id'];
        list($this->attributes['first_name'], $this->attributes['last_name']) = explode(' ', $info['name']);
        if (! empty($info['link'])) {
            $this->attributes['url'] = $info['link'];
        }
    }
} 