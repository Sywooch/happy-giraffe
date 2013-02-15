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
    private $city;
    protected $debug_mode = false;
    protected $use_proxy;

    public function __construct($debug_mode = false, $use_proxy = false)
    {
        $this->debug_mode = $debug_mode;
        $this->use_proxy = $use_proxy;
    }

    public function start()
    {
        Yii::import('site.seo.models.*');
        time_nanosleep(rand(0, 60), rand(0, 1000000000));

        for ($i = 0; $i < 10000; $i++) {
            $this->getCity();
            $this->parseCity();
        }
    }

    public function getCity()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'type="г" AND id NOT IN (Select city_id from geo__city_coordinates)';
        $criteria->offset = rand(0, 10);
        $this->city = GeoCity::model()->find($criteria);

        $this->log('city_id: ' . $this->city->id);
    }

    public function parseCity($attempt = 0)
    {
        $city_string = $this->city->getFullName();
        //echo $city_string.'<br>';

        $url = 'http://maps.google.com/maps/api/geocode/json?address=' . urlencode($city_string) . '&sensor=false';

        $text = $this->loadPage($url);
        $result = json_decode($text, true);

        if (isset($result['status']) && $result['status'] == 'OK') {
            $this->saveCoordinates($result['results'][0]['geometry']);
        } else {
            $this->log('status: ' . $result['status']);

            if ($result['status'] == 'NOT_FOUND') {
                echo $this->city->id . "\n";
            } else {
                if ($attempt > 50) {
                    var_dump($text);
                    Yii::app()->end();
                }

                $attempt++;
                $this->parseCity($attempt);
            }
        }
    }

    public function saveCoordinates($result)
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
}