<?php

namespace site\frontend\modules\geo2\components;
use site\frontend\modules\geo2\components\combined\models\Geo2City;

/**
 * @author Никита
 * @date 22/03/17
 */
class LocationRecognizer
{
    const LEVENSHTEIN_THRESHOLD = 0.5;

    public static function recognizeCity($countryIsoCode, $cityName, $regionName)
    {
        $cities = self::getCities($countryIsoCode, $cityName);
        $nCities = count($cities);
        switch ($nCities) {
            case 0:
                return null;
            case 1:
                return $cities[1];
            default:
                return self::chooseCity($cities, $regionName);
        }
    }
    
    public static function getCities($countryIsoCode, $cityName)
    {
        return Geo2City::model()->title($cityName)->with([
            'country' => [
                'joinType' => 'INNER JOIN',
                'scopes' => [
                    'iso' => [$countryIsoCode],
                ],
            ],
        ])->findAll();
    }

    protected static function chooseCity($cities, $regionName)
    {
        $shortest = PHP_INT_MAX;
        $closest = null;
        foreach ($cities as $city) {
            if (! $city->region) {
                continue;
            }

            $lev = levenshtein($regionName, $city->region->title);

            if ($lev == 0) {
                return $city;
            }

            if ($lev < $shortest) {
                $closest = $city;
                $shortest = $lev;
            }
        }
        
        $ratio = $shortest / strlen($regionName);
        return ($ratio < self::LEVENSHTEIN_THRESHOLD) ? $closest : null;
    }
}