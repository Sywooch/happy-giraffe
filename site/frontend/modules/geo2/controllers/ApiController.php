<?php

namespace site\frontend\modules\geo2\controllers;
use GeoIp2\Exception\AddressNotFoundException;
use site\frontend\modules\geo2\components\combined\models\Geo2City;
use site\frontend\modules\geo2\components\combined\models\Geo2Country;
use site\frontend\modules\geo2\components\LocationRecognizer;

/**
 * @author Никита
 * @date 31/03/17
 */
class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionLocateCity()
    {
        try {
            $record = \Yii::app()->geoLite->city($_SERVER['REMOTE_ADDR']);
            $city = LocationRecognizer::recognizeCity($record->country->isoCode, $record->city->name, $record->mostSpecificSubdivision->name);
        } catch (AddressNotFoundException $e) {
            $city = null;
        }
        $this->success = true;
        $this->data = [
            'city' => $city,
        ];
    }

    public function actionGetCountries()
    {
        $countries = Geo2Country::model()->findAll();
        $this->success = true;
        $this->data = [
            'countries' => $countries,
        ];
    }

    public function actionGetCities($countryId, $q = false)
    {
        $cities = Geo2City::model()->country($countryId)->search($q)->findAll(['limit' => 10]);
        $this->success = true;
        $this->data = [
            'cities' => $cities,
        ];
    }

    public function actionUpdateLocation($userId, $cityId = null, $countryId = null)
    {
        $location = \User::model()->findByPk($userId)->location;
        $location->countryId = $countryId;
        $location->cityId = $cityId;
        $this->success = $location->save();
        $this->data = [
            'location' => $location,    
        ];
    }
}