<?php
/**
 * Author: alexk984
 * Date: 13.02.13
 */
class GoogleRouteParser
{
    /**
     * @var Route
     */
    private $route;

    /**
     * @param $route Route
     */
    public static function parseRoute($route)
    {
        $p = new GoogleRouteParser;
        $p->parse($route);
    }

    /**
     * @param $route Route
     */
    public function parse($route)
    {
        $this->route = $route;
        $result = $this->loadPage();
        //var_dump($result);

        $legs = $result['routes'][0]['legs'][0];
        $this->route->distance = round($legs['distance']['value'] / 1000);
        $this->route->save();

        $this->parseSteps($legs['steps']);
    }

    /**
     * @param $steps array
     */
    private function parseSteps($steps)
    {
        $coordinates_parser = new GoogleMapsGeoCode;
        $distance = 0;
        $time = 0;
        $prev_city_id = $this->route->city_from_id;
        foreach ($steps as $step) {
            $distance += $step['distance']['value'];
            $time += $step['duration']['value'];
            $lat = $step['end_location']['lat'];
            $lng = $step['end_location']['lng'];

            $city = $coordinates_parser->getCityByCoordinates($lat, $lng);
            if ($city !== null && $prev_city_id != $city->id && $city->id != $this->route->city_to_id) {
                $p = new RosnPoints();
                $p->route_id = $this->route->id;
                $p->name = $city->name;
                $p->region_id = $city->region->id;
                $p->city_id = $city->id;
                $p->distance = round($distance / 1000);
                $p->time = round($time/60);
                $p->save();

                $prev_city_id = $city->id;
                $distance = 0;
                $time = 0;
            }
        }

        //save last city
        $p = new RosnPoints();
        $p->route_id = $this->route->id;
        $p->name = $this->route->cityTo->name;
        $p->region_id = $this->route->cityTo->region->id;
        $p->city_id = $this->route->cityTo->id;
        $p->distance = round($distance / 1000);
        $p->time = round($time/60);
        $p->save();
    }

    private function loadPage()
    {
        $url = 'http://maps.googleapis.com/maps/api/directions/json?origin='
            . urlencode($this->route->cityFrom->getFullName()) . '&destination='
            . urlencode($this->route->cityTo->getFullName()) . '&sensor=false';
        $text = file_get_contents($url);
        return json_decode($text, true);
    }
}
