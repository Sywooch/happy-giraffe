<?php
/**
 * Author: alexk984
 * Date: 23.01.13
 */

class GoogleCoordinatesParser
{
    /**
     * @var GeoCity
     */
    public $city;

    public function start()
    {
        while (true) {
            $this->getCity();
            $this->parseCity();
        }
    }

    public function getCity()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'id NOT IN (Select city_id from geo__city_coordinates)';

        $this->city = GeoCity::model()->find($criteria);
    }

    public function parseCity()
    {
        $city_string = $this->city->getFullName();
        echo $city_string.'<br>';
        $url = 'http://maps.google.com/maps/api/geocode/json?address=' . urlencode($city_string) . '&sensor=false';

        $text = file_get_contents($url);
        $result = json_decode($text, true);

        if ($result['status'] == 'OK'){
            var_dump($result['results'][0]['geometry']);
        }

        $coordinates = new CityCoordinates;
        $coordinates->city_id = $this->city->id;
        $coordinates->location_lat = round($result['results'][0]['geometry']['location']['lat'], 8);
        $coordinates->location_lng = round($result['results'][0]['geometry']['location']['lng'], 8);
        $coordinates->northeast_lat = round($result['results'][0]['geometry']['bounds']['northeast']['lat'], 8);
        $coordinates->northeast_lng = round($result['results'][0]['geometry']['bounds']['northeast']['lng'], 8);
        $coordinates->southwest_lat = round($result['results'][0]['geometry']['bounds']['southwest']['lat'], 8);
        $coordinates->southwest_lng = round($result['results'][0]['geometry']['bounds']['southwest']['lng'], 8);
        $coordinates->save();

        Yii::app()->end();
    }
}