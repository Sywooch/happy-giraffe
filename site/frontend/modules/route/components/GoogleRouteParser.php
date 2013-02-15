<?php
/**
 * Author: alexk984
 * Date: 13.02.13
 */
class GoogleRouteParser extends GoogleMapsApiParser
{
    /**
     * @var Route
     */
    private $route;

    public function startParse()
    {
        while (true) {
            $this->getRoute();
            $this->parse();
        }
    }

    private function getRoute()
    {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $criteria = new CDbCriteria;
            $criteria->condition = 'status=0';
            $criteria->order = 'rand()';
            $this->route = Route::model()->find($criteria);
            $this->route->status = 1;
            $this->route->save();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::app()->end();
        }
    }

    /**
     * @param $route Route
     */
    public static function parseRoute($route)
    {
        $p = new GoogleRouteParser;
        $p->route = $route;
        $p->parse();
    }

    private function parse()
    {
        //remove steps if exists
        RoutePoint::model()->deleteAll('route_id = :route_id', array(':route_id' => $this->route->id));

        $result = $this->loadDirection();
        //var_dump($result);

        if ($result['status'] == 'ZERO_RESULTS'){
            $this->route->status = Route::STATUS_ZERO_RESULT;
            $this->route->save();
        } elseif ($result['status'] == 'NOT_FOUND'){
            $this->route->status = Route::STATUS_NOT_FOUND;
            $this->route->save();
        } else {
            if (!isset($result['routes'][0]))
                return null;
            $legs = $result['routes'][0]['legs'][0];
            $this->route->distance = round($legs['distance']['value'] / 1000);
            $this->route->save();

            $this->parseSteps($legs['steps']);

            $this->route->status = Route::STATUS_GOOGLE_PARSE_SUCCESS;
            $this->route->save();
        }
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

            if ($city !== null && $prev_city_id != $city->id && $city->name != $this->route->cityTo->name) {
                $p = new RoutePoint();
                $p->route_id = $this->route->id;
                $p->name = $city->name;
                if (!empty($city->region))
                    $p->region_id = $city->region->id;
                $p->city_id = $city->id;
                $p->distance = round($distance / 1000);
                $p->time = round($time / 60);
                $p->save();

                $prev_city_id = $city->id;
                $distance = 0;
                $time = 0;
            }
        }

        //save last city
        $p = new RoutePoint();
        $p->route_id = $this->route->id;
        $p->name = $this->route->cityTo->name;
        if (!empty($this->route->cityTo->region))
            $p->region_id = $this->route->cityTo->region->id;
        $p->city_id = $this->route->cityTo->id;
        $p->distance = round($distance / 1000);
        $p->time = round($time / 60);
        $p->save();
    }

    private function loadDirection()
    {
        $url = 'http://maps.googleapis.com/maps/api/directions/json?origin='
            . urlencode($this->route->cityFrom->getFullName()) . '&destination='
            . urlencode($this->route->cityTo->getFullName()) . '&sensor=false';
        return $this->loadPage($url);
    }
}
