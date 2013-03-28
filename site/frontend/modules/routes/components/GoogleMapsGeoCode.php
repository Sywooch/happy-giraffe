<?php
/**
 * Author: alexk984
 * Date: 25.01.13
 */
class GoogleMapsGeoCode extends GoogleMapsApiParser
{
    public function getObjectNameByCoordinates($lat, $lng)
    {
        Yii::import('site.frontend.modules.geo.models.*');

        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&sensor=true&language=ru';
        $result = $this->loadPage($url);
        if (isset($result['status']) && $result['status'] == 'OK') {
            $address = self::getAddressComponentsByType($result['results']);

            if ($address === null)
                return $result['results'][0]['formatted_address'];

            return $this->getAddressComponent($address, 'locality');
        } else {
            return null;
        }
    }

    /**
     * @param $lat
     * @param $lng
     * @return null|GeoCity
     */
    public function getCityByCoordinates($lat, $lng)
    {
        $city = RouteCoordinates::getCity($lat, $lng);

        if ($city)
            return $city;

        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&sensor=true&language=ru';
        $result = $this->loadPage($url);

        if (isset($result['status']) && $result['status'] == 'OK') {
            $address = self::getAddressComponentsByType($result['results']);
            if ($address === null) {
                RouteCoordinates::saveCoordinates($lat, $lng, null);
                return null;
            }

            $country_code = self::getCountryCode($address);
            $region = self::getRegionTitle($address);
            $district = self::getDistrictTitle($address);
            $city = self::getCityTitle($address);

            $city = self::getCity($country_code, $region, $district, $city);

            RouteCoordinates::saveCoordinates($lat, $lng, $city);
            return $city;
        } else {
            return null;
        }
    }

    private function getCity($country_code, $region_title, $district_title, $city_title)
    {
        $country = self::getCountry($country_code);
        if (empty($country) || empty($city_title))
            return null;
        if (empty($region_title))
            $region_title = $city_title;

        if ($region_title == $city_title)
            $region = self::getRegion($country, $region_title, 'г');
        else
            $region = self::getRegion($country, $region_title);

        $district = self::getDistrict($region, $district_title);

        $city = GeoCity::model()->findByAttributes(array(
            'country_id' => $country->id,
            'region_id' => empty($region) ? null : $region->id,
            'district_id' => empty($district) ? null : $district->id,
            'name' => $city_title
        ));

        if ($city === null) {
            //проверяем если такой город уже есть, но у него НЕ УКАЗАН район
            if (!empty($district)) {
                $city = GeoCity::model()->findByAttributes(array(
                    'country_id' => $country->id,
                    'region_id' => empty($region) ? null : $region->id,
                    'district_id' => null,
                    'name' => $city_title
                ));
                if ($city !== null) {
                    //обновляем район города
                    $city->district_id = $district->id;
                    $city->save();

                    return $city;
                }
            } elseif (empty($district)) {
                //проверяем если такой город уже есть, но у него УКАЗАН район
                $city = GeoCity::model()->findByAttributes(array(
                    'country_id' => $country->id,
                    'region_id' => empty($region) ? null : $region->id,
                    'name' => $city_title
                ));
                if ($city !== null) {
                    return $city;
                }
            }

            $city = new GeoCity();
            $city->country_id = $country->id;
            if (!empty($region))
                $city->region_id = $region->id;
            if (!empty($district))
                $city->district_id = $district->id;
            $city->name = $city_title;
            $city->auto_created = 1;
            $city->save();
        }

        return $city;
    }

    /**
     * @param $region
     * @param $district_title
     * @return GeoDistrict|null
     */
    private function getDistrict($region, $district_title)
    {
        if (empty($district_title) || empty($region))
            return null;

        if (strpos($district_title, 'город ') === 0)
            return null;

        $district_title = str_replace('район', '', $district_title);
        $district_title = trim($district_title);

        $district = GeoDistrict::model()->findByAttributes(array(
            'region_id' => $region->id,
            'name' => $district_title
        ));
        if ($district === null) {
            $district = new GeoDistrict();
            $district->region_id = $region->id;
            $district->name = $district_title;
            $district->auto_created = 1;
            $district->save();
        }

        return $district;
    }

    /**
     * @param GeoCountry $country
     * @param $region_title
     * @param null|string $type
     * @return GeoCountry|null
     */
    private function getRegion($country, $region_title, $type = null)
    {
        if (empty($region_title))
            return null;

        $region = GeoRegion::model()->find('country_id=:country_id AND (name=:name) OR google_name=:name',
            array(':country_id' => $country->id, 'name' => $region_title));

        if ($region === null) {
            //проверяем если подставить "Республика"
            $region = GeoRegion::model()->findByAttributes(array('country_id' => $country->id, 'name' => 'Республика ' . $region_title));
            if ($region !== null)
                return $region;
            $region = GeoRegion::model()->findByAttributes(array('country_id' => $country->id, 'name' => $region_title . ' автономный округ'));
            if ($region !== null)
                return $region;

            $region = new GeoRegion;
            $region->country_id = $country->id;
            $region->position = 1000;
            $region->name = $region_title;
            $region->auto_created = 1;
            if (!empty($type))
                $region->type = $type;
            $region->save();
        }

        return $region;
    }

    /**
     * @param $country_code
     * @return GeoCountry|null
     */
    private function getCountry($country_code)
    {
        if (empty($country_code))
            return null;

        return GeoCountry::model()->findByAttributes(array('iso_code' => $country_code));
    }

    /**
     * Returns country code like RU|UA
     *
     * @param $address
     * @return string
     */
    private function getCountryCode($address)
    {
        return self::getAddressComponent($address, 'country', 'short_name');
    }

    /**
     * Returns region title, like 'Волгоградская область'
     *
     * @param $address
     * @return string
     */
    private function getRegionTitle($address)
    {
        $title = self::getAddressComponent($address, 'administrative_area_level_1');
        if (strpos($title, 'г.') === 0)
            $title = str_replace('г. ', '', $title);
        if (strpos($title, 'город ') === 0)
            $title = str_replace('город ', '', $title);

        return trim($title);
    }

    /**
     * Returns district title, like 'район Дубовский' or 'город Волгоград'
     *
     * @param $address
     * @return string
     */
    private function getDistrictTitle($address)
    {
        $title = self::getAddressComponent($address, 'administrative_area_level_2');
        if (strpos($title, 'г.') === 0 || strpos($title, 'город ') === 0)
            return null;

        return $title;
    }

    /**
     * Returns city title
     *
     * @param $address
     * @return string
     */
    private function getCityTitle($address)
    {
        $title = self::getAddressComponent($address, 'locality');
        $replace_types = array('г.', 'с.', 'ст.', 'п.', 'ст-ца', 'город', 'д.', 'им.');
        foreach ($replace_types as $replace_type) {
            if (strpos($title, $replace_type . ' ') !== false)
                $title = str_replace($replace_type . ' ', '', $title);
            if (strpos($title, ' ' . $replace_type) !== false)
                $title = str_replace(' ' . $replace_type, '', $title);
        }

        return $title;
    }

    /**
     * Returns some address component
     *
     * @param $address_components
     * @param $type
     * @param string $name
     * @return string|null
     */
    private function getAddressComponent($address_components, $type, $name = 'long_name')
    {
        foreach ($address_components as $component)
            if (is_array($component['types']) && in_array($type, $component['types']))
                return $component[$name];

        return null;
    }

    /**
     * @param $addresses
     * @param string $type
     * @return null
     */
    private function getAddressComponentsByType($addresses, $type = 'locality')
    {
        foreach ($addresses as $address) {
            if (in_array($type, $address['types']) && isset($address['address_components']))
                return $address['address_components'];
        }

        return null;
    }
}
