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
        //while (true) {
        for ($i = 0; $i < 10000; $i++) {
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
        $url = 'http://maps.google.com/maps/api/geocode/json?address=' . urlencode($city_string) . '&sensor=false';

        $text = file_get_contents($url);
        $result = json_decode($text, true);

        if (isset($result['status']) && $result['status'] == 'OK') {
            $this->saveCoordinates($result['results'][0]['geometry']);
        } else {
            $this->parseCity();
        }
    }

    public function loadPage($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXY, '46.165.200.102:999');

        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexhg:Nokia1111");
        curl_setopt($ch, CURLOPT_PROXYAUTH, 1);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result === false)
            return $this->loadPage($url);

        return $result;
    }

    public function saveCoordinates($result)
    {
        $coordinates = new CityCoordinates;
        $coordinates->city_id = $this->city->id;
        $coordinates->location_lat = round($result['location']['lat'], 8);
        $coordinates->location_lng = round($result['location']['lng'], 8);
        $coordinates->northeast_lat = round($result['bounds']['northeast']['lat'], 8);
        $coordinates->northeast_lng = round($result['bounds']['northeast']['lng'], 8);
        $coordinates->southwest_lat = round($result['bounds']['southwest']['lat'], 8);
        $coordinates->southwest_lng = round($result['bounds']['southwest']['lng'], 8);
        $coordinates->save();
    }
}