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
    protected function fetchAttributes()
    {
        $info = $this->makeSignedRequest('http://api.odnoklassniki.ru/fb.do', array(
            'query' => array(
                'method' => 'users.getCurrentUser',
                'format' => 'JSON',
                'application_key' => $this->client_public,
                'client_id' => $this->client_id,
                'fields' => 'uid, first_name, last_name, gender, birthday, location, pic50x50, pic128x128, pic128max, pic180min, pic240min, pic320min, pic190x190, pic640x480, pic1024x768',
            ),
        ));

        $this->attributes['uid'] = $info->uid;
        $this->attributes['firstName'] = $info->first_name;
        $this->attributes['lastName'] = $info->last_name;
        $this->attributes['email'] = null;
        $this->setBirthdayAttributes($info);
        $this->attributes['gender'] = $info->gender == 'male' ? '1' : '0';
        $this->setLocationAttributes($info);
        $this->setAvatarAttribute($info);
    }

    protected function setAvatarAttribute($info)
    {
        $avatarAttributes = array(
            'pic1024x768',
            'pic640x480',
            'pic190x190',
            'pic320min',
            'pic240min',
            'pic180min',
            'pic128max',
            'pic128x128',
            'pic50x50',
        );

        $result = null;
        $curl = curl_init();
        foreach ($avatarAttributes as $attr) {
            $url = $info->$attr;
            if (preg_match('#\/stub_(\d+)x(\d+).gif#', $url) === 0) {
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_exec($curl);
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($httpCode == 200) {
                    $result = $url;
                    break;
                }
            }

        }
        curl_close($curl);
        $this->attributes['avatarSrc'] = $result;
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
        }

        $this->attributes['birthday_year'] = $year;
        $this->attributes['birthday_month'] = $month;
        $this->attributes['birthday_day'] = $day;
    }

    protected function setLocationAttributes($info)
    {
        $countryModel = GeoCountry::model()->findByAttributes(array('iso_code' => $info->location->countryCode));
        if ($countryModel === null) {
            $this->attributes['country'] = null;
            $this->attributes['city'] = null;
        }
        else {
            $this->attributes['country_id'] = $countryModel->id;
            $citiesCount = GeoCity::model()->countByAttributes(array('country_id' => $countryModel->id, 'name' => $info->location->city));
            if ($citiesCount == 1) {
                $cityModel = GeoCity::model()->findByAttributes(array('country_id' => $countryModel->id, 'name' => $info->location->city));
                $this->attributes['city_id'] = $cityModel->id;
            }
            else
                $this->attributes['city_id'] = null;
            $this->attributes['city_name'] = $info->location->city;
        }
    }
}