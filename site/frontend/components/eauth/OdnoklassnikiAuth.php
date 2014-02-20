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
                'fields' => 'uid, first_name, last_name, gender, birthday, location, pic1024x768',
            ),
        ));

        $this->attributes['id'] = $info->uid;
        $this->attributes['first_name'] = $info->first_name;
        $this->attributes['last_name'] = $info->last_name;
        $this->attributes['email'] = null;
        $this->setBirthdayAttributes($info);
        $this->attributes['gender'] = $info->gender == 'male' ? 1 : 0;
        $this->setLocationAttributes($info);
        $this->attributes['avatar_src'] = $info->pic1024x768;
    }

    protected function setBirthdayAttributes($info)
    {
        $array = explode('-', $info->birthday);
        $this->attributes['birthday_year'] = $array[0];
        $this->attributes['birthday_month'] = ltrim($array[1], '0');
        $this->attributes['birthday_day'] = ltrim($array[2], '0');
    }

    protected function setLocationAttributes($info)
    {
        $countryModel = GeoCountry::model()->findByAttributes(array('iso_code' => $info->location->countryCode));
        if ($countryModel === null) {
            $this->attributes['country'] = null;
            $this->attributes['city'] = null;
        }
        else {
            $this->attributes['country'] = $countryModel->id;
            $citiesCount = GeoCity::model()->countByAttributes(array('country_id' => $countryModel->id, 'name' => $info->location->city));
            if ($citiesCount == 1) {
                $cityModel = GeoCity::model()->findByAttributes(array('country_id' => $countryModel->id, 'name' => $info->location->city));
                $this->attributes['city'] = $cityModel->id;
            }
            else
                $this->attributes['city'] = null;
        }
    }
}