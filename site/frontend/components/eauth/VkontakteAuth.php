<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 19/02/14
 * Time: 16:30
 * To change this template use File | Settings | File Templates.
 */

class VkontakteAuth extends VKontakteOAuthService
{
    protected function fetchAttributes() {
        $info = (array)$this->makeSignedRequest('https://api.vk.com/method/users.get.json', array(
            'query' => array(
                'uids' => $this->uid,
                //'fields' => '', // uid, first_name and last_name is always available
                'fields' => 'nickname, sex, bdate, city, country, timezone, photo, photo_medium, photo_big, photo_rec',
            ),
        ));

        $info = $info['response'][0];

        $this->attributes['id'] = $info->uid;
        $this->attributes['first_name'] = $info->first_name;
        $this->attributes['last_name'] = $info->last_name;
        $this->attributes['email'] = null;
        $this->setBirthdayAttributes($info);
        $this->attributes['gender'] = $info->sex == 0 ? null : $info->sex - 1;
        $this->setLocationAttributes($info);
    }

    protected function setBirthdayAttributes($info)
    {
        if (isset($info->bdate)) {
            $array = explode('.', $info->bdate);
            $day = $array[0];
            $month = $array[1];
            $year = (count($array) == 3) ? $array[2] : null;
        } else {
            $day = null;
            $month = null;
            $year = null;
        }
        $this->attributes['birthday_year'] = $year;
        $this->attributes['birthday_month'] = $month;
        $this->attributes['birthday_day'] = $day;
    }

    protected function setLocationAttributes($info)
    {
        if (isset($info->country)) {
            $countryInfo = $this->makeSignedRequest('https://api.vk.com/method/places.getCountryById.json', array(
                'query' => array(
                    'cids' => $info->country,
                ),
            ));
            $countryModel = GeoCountry::model()->findByAttributes(array('name' => $countryInfo->response[0]->name));
            $this->attributes['country'] = ($countryModel === null) ? null : $countryModel->id;

            if (isset($info->city)) {
                $cityInfo = $this->makeSignedRequest('https://api.vk.com/method/places.getCityById.json', array(
                    'query' => array(
                        'cids' => $info->city,
                    ),
                ));
                $citiesCount = array('country_id' => $countryModel->id, 'name' => $cityInfo->response[0]->name);
                if ($citiesCount == 1) {
                    $cityModel = GeoCity::model()->findByAttributes(array('country_id' => $countryModel->id, 'name' => $cityInfo->response[0]->name));
                    $this->attributes['city'] = $cityModel->id;
                }
                else
                    $this->attributes['city'] = null;
            }
        }
    }
}