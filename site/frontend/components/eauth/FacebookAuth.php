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
        $countryModel = GeoCountry::model()->findByAttributes(array('iso_code' => $location->location->country_code));
        if ($countryModel === null) {
            return;
        }
        $this->attributes['country_id'] = $countryModel->id;

        if (preg_match('#^[а-яА-Я -]+$#u', $location->name)) {
            $pieces = explode(', ', $location->name);
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
        } else {
            $cityName = $this->decode($location->location->city);
            $regionName = $this->decode($location->location->region);
        }
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

    protected function decode($string)
    {
        $roman = array("Sch","sch",'Yo','Zh','Kh','Ts','Ch','Sh','Yu','ya','yo','zh','kh','ts','ch','sh','yu','ya','A','B','V','G','D','E','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','','Y','','E','a','b','v','g','d','e','z','i','y','k','l','m','n','o','p','r','s','t','u','f','','y','','e');
        $cyrillic = array("Щ","щ",'Ё','Ж','Х','Ц','Ч','Ш','Ю','я','ё','ж','х','ц','ч','ш','ю','я','А','Б','В','Г','Д','Е','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Ь','Ы','Ъ','Э','а','б','в','г','д','е','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','ь','ы','ъ','э');
        return str_replace($roman, $cyrillic, $string);
    }
}