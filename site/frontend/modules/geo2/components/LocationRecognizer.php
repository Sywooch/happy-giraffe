<?php

namespace site\frontend\modules\geo2\components;
use site\frontend\modules\geo2\components\combined\models\Geo2City;

/**
 * @author Никита
 * @date 22/03/17
 */
class LocationRecognizer
{
    public static function recognizeCity($cityName, $regionName)
    {
        $cities = Geo2City::model()->with('region')->findAllByAttributes(['title' => $cityName]);
        if (count($cities) == 1) {
            return $cities[0];
        }

        $shortest = -1;
        $closest = null;
        foreach ($cities as $city) {
            $lev = levenshtein($city->region->title, $regionName);

            if ($lev == 0) {
                return $city;
            }

            if ($lev <= $shortest || $shortest < 0) {
                $closest = $city;
                $shortest = $lev;
            }
        }
        return $closest;
    }
}