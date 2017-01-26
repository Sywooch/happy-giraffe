<?php
/**
 * @author Никита
 * @date 16/02/16
 */

class FacebookAuth extends FacebookOAuthService
{
    const REGION_SIMILAR_THRESHOLD = 50;

    protected $scope = 'public_profile, email, user_location';

    protected function fetchAttributes()
    {
        $info = (object)$this->makeSignedRequest('https://graph.facebook.com/v2.8/me', array(
            'query' => array(
                'fields' => 'first_name, location{location{city, city_id, region, region_id, located_in, country, country_code}, name}, last_name, email, gender, picture.height(200).width(200)',
                'locale' => 'ru_RU',
            ),
        ));

        $this->attributes['uid'] = $info->id;
        $this->attributes['firstName'] = $info->first_name;
        $this->attributes['lastName'] = $info->last_name;
        if (isset($info->email)) {
            $this->attributes['email'] = $info->email;
        }
        $this->attributes['gender'] = $this->processGender($info->gender);
        $this->attributes['avatarSrc'] = $info->picture->data->url;
        $this->setLocationAttributes($info);
    }

    protected function processGender($fbGender)
    {
        switch ($fbGender) {
            case 'male':
                return 1;
                break;
            case 'female':
                return 0;
                break;
            default:
                return null;
        }
    }

    protected function setLocationAttributes($info)
    {
        if (! isset($info->location)) {
            return;
        }
        
        $location = $info->location;
        $this->saveLocation($location);
        $countryModel = GeoCountry::model()->findByAttributes(array('iso_code' => $location->country_code));
        if ($countryModel === null) {
            return;
        }
        $this->attributes['country_id'] = $countryModel->id;
         
        $pieces = explode(', ', $info->location->name);
        if (count($pieces) == 1) {
            $cityName = $pieces;
            $regionName = null;
        } elseif (count($pieces) == 2) {
            $cityName = $pieces[0];
            $regionName = $pieces[1];
        } else {
            return;
        }
        $cityName = str_replace('г. ', '', $cityName);
        $citiesModels = GeoCity::model()->findAllByAttributes(array('country_id' => $countryModel->id, 'name' => $cityName));
        $cityModel = \site\frontend\modules\geo\helpers\GeoHelper::chooseCityByRegion($citiesModels, $regionName);
        if ($cityModel) {
            $this->attributes['city_id'] = $cityModel->id;
        }
    }
    
    protected function saveLocation($data)
    {
        $socialLocation = (new \site\frontend\modules\signup\models\SocialLocation());
        $socialLocation->setAttributes([
            'service' => $this->getServiceName(),
            'serviceId' => $this->getAttribute('uid'),
            'data' => $data,
        ]);
        $socialLocation->save();
    }
}