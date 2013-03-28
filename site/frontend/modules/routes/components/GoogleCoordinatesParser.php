<?php
/**
 * Author: alexk984
 * Date: 23.01.13
 */

class GoogleCoordinatesParser extends GoogleMapsApiParser
{
    /**
     * @var SeoCityCoordinates
     */
    public $coordinates;
    /**
     * @var GeoCity
     */
    public $city;

    public function start()
    {
        Yii::import('site.seo.models.*');
        time_nanosleep(rand(0, 10), rand(0, 1000000000));

        for ($i = 0; $i < 10000; $i++) {
            $this->getCity();
            $this->parseCity();
        }
    }

    private function getCity()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'id NOT IN (Select city_id from geo__city_coordinates) AND id IN (SELECT DISTINCT(city_id) FROM  `routes__points`)';
        //$criteria->offset = rand(0, 10);
        $this->city = GeoCity::model()->find($criteria);
        if ($this->city == null)
            Yii::app()->end();
    }

    public function parseCity()
    {
        $city_string = $this->city->getFullName();

        $url = 'http://maps.google.com/maps/api/geocode/json?address=' . urlencode($city_string) . '&sensor=false&language=ru';
        $result = $this->loadPage($url);

        if (isset($result['status']) && $result['status'] == 'OK') {
              if (mb_strpos($result['results'][0]['formatted_address'], $this->city->name, 0, 'UTF-8') !== false)
                $this->saveCoordinates($result['results'][0]['geometry']);
            else
                $this->saveEmptyCoordinates();
        } else {
            $this->log('status: ' . $result['status']);

            if ($result['status'] == 'ZERO_RESULTS') {
                $this->saveEmptyCoordinates();
            }
        }
    }

    private function saveCoordinates($result)
    {
        $this->coordinates = new CityCoordinates();
        $this->coordinates->city_id = $this->city->id;
        $this->coordinates->location_lat = round($result['location']['lat'], 5);
        $this->coordinates->location_lng = round($result['location']['lng'], 5);
        if (isset($result['bounds']['northeast'])) {
            $this->coordinates->northeast_lat = round($result['bounds']['northeast']['lat'], 8);
            $this->coordinates->northeast_lng = round($result['bounds']['northeast']['lng'], 8);
            $this->coordinates->southwest_lat = round($result['bounds']['southwest']['lat'], 8);
            $this->coordinates->southwest_lng = round($result['bounds']['southwest']['lng'], 8);
        }
        try {
            $this->coordinates->save();
        } catch (Exception $err) {

        }
    }

    private function saveEmptyCoordinates()
    {
        $this->coordinates = new CityCoordinates();
        $this->coordinates->city_id = $this->city->id;
        $this->coordinates->location_lat = 0;
        $this->coordinates->location_lng = 0;
        try {
            $this->coordinates->save();
        } catch (Exception $err) {

        }
    }
}