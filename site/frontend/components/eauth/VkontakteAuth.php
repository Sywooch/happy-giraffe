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
    protected $scope = 'email';

    protected function fetchAttributes() {
        $info = (array)$this->makeSignedRequest('https://api.vk.com/method/users.get.json', array(
            'query' => array(
                'uids' => $this->uid,
                //'fields' => '', // uid, first_name and last_name is always available
                'fields' => 'sex, bdate, city, country, photo_max_orig, photo_max, photo_400_orig, photo_200, photo_200_orig, photo_100, photo_50',
            ),
        ));

        $info = $info['response'][0];

        $this->attributes['uid'] = $info->uid;
        $this->attributes['firstName'] = $info->first_name;
        $this->attributes['lastName'] = $info->last_name;
        $this->setBirthdayAttributes($info);
        $this->attributes['gender'] = $info->sex == 0 ? null : (($info->sex == 1 ? '0' : '1'));
        $this->setLocationAttributes($info);
        $this->setAvatarAttribute($info);
    }

    protected function setAvatarAttribute($info)
    {
        if ($info->photo_max != 'http://vk.com/images/camera_b.gif') {
            $avatarSrc = $info->photo_max;
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

        if (isset($info->bdate)) {
            $array = explode('.', $info->bdate);
            $count = count($array);
            if ($count == 2 || $count == 3) {
                $day = $array[0];
                $month = $array[1];
                if ($count == 3)
                    $year = $array[2];
            }
        }

        $this->attributes['birthday'] = implode('-', array($year, $month, $day));
    }

    protected function saveAccessToken($token)
    {
        if (isset($token->email)) {
            $this->attributes['email'] = $token->email;
        }
        parent::saveAccessToken($token);
    }

    protected function setLocationAttributes($info)
    {
        if ($info->country != 0) {
            $countryInfo = $this->makeSignedRequest('https://api.vk.com/method/places.getCountryById.json', array(
                'query' => array(
                    'cids' => $info->country,
                ),
            ));
            $countryModel = GeoCountry::model()->findByAttributes(array('name' => $countryInfo->response[0]->name));
            $this->attributes['country_id'] = ($countryModel === null) ? null : $countryModel->id;

            if ($info->city != 0) {
                $cityInfo = $this->makeSignedRequest('https://api.vk.com/method/places.getCityById.json', array(
                    'query' => array(
                        'cids' => $info->city,
                    ),
                ));
                $citiesCount = array('country_id' => $countryModel->id, 'name' => $cityInfo->response[0]->name);
                if ($citiesCount == 1) {
                    $cityModel = GeoCity::model()->findByAttributes(array('country_id' => $countryModel->id, 'name' => $cityInfo->response[0]->name));
                    $this->attributes['city_id'] = $cityModel->id;
                }
                else
                    $this->attributes['city_id'] = null;
                $this->attributes['city_name'] = $cityInfo->response[0]->name;
            }
        }
    }
}