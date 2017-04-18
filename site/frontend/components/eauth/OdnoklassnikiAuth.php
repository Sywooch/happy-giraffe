<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 19/02/14
 * Time: 16:23
 * To change this template use File | Settings | File Templates.
 */

class OdnoklassnikiAuth extends OdnoklassnikiOAuthService
{
    protected $scope = 'GET_EMAIL';

    protected function fetchAttributes()
    {
        $info = $this->makeSignedRequest('http://api.odnoklassniki.ru/fb.do', array(
            'query' => array(
                'method' => 'users.getCurrentUser',
                'format' => 'JSON',
                'application_key' => $this->client_public,
                'client_id' => $this->client_id,
                'fields' => 'uid, email, first_name, last_name, gender, birthday, pic50x50, pic128x128, pic128max, pic180min, pic240min, pic320min, pic190x190, pic640x480, pic1024x768',
            ),
        ));

        $this->attributes['uid'] = $info->uid;
        $this->attributes['firstName'] = $info->first_name;
        $this->attributes['lastName'] = $info->last_name;
        if (isset($info->email)) {
            $this->attributes['email'] = $info->email;
        }
        $this->setBirthdayAttributes($info);
        $this->attributes['gender'] = $info->gender == 'male' ? '1' : '0';
        $this->setAvatarAttribute($info);
    }

    protected function setAvatarAttribute($info)
    {
        if (isset($info->pic190x190) && (strpos($info->pic190x190, 'stub') === false)) {
            $avatarSrc = $info->pic190x190;
        } else {
            $avatarSrc = null;
        }
        $this->attributes['avatarSrc'] = $avatarSrc;
    }

    protected function setBirthdayAttributes($info)
    {
        $day = null;
        $month = null;
        $year = null;

        if (isset($info->birthday)) {
            $array = explode('-', $info->birthday);
            $count = count($array);
            if ($count == 2 || $count == 3) {
                if ($count == 3)
                    $year = $array[0];
                $month = ltrim($array[$count - 2], '0');
                $day = ltrim($array[$count - 1], '0');
            }

            $this->attributes['birthday'] = implode('-', array($year, $month, $day));
        }
    }
}