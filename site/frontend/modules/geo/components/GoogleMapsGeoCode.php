<?php
/**
 * Author: alexk984
 * Date: 25.01.13
 */
class GoogleMapsGeoCode extends CComponent
{
    public function init()
    {
        Yii::import('site.frontend.modules.geo.models.*');
    }

    public function getCityByCoordinates($lat, $lng)
    {
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&sensor=true&language=ru';

        $text = file_get_contents($url);
        $result = json_decode($text, true);

        if (isset($result['status']) && $result['status'] == 'OK') {

            $address = self::getAddressComponentsByType($result['results']);
            var_dump($address);
            if ($address === null)
                return null;

            echo $country_code = self::getCountryCode($address);
            echo '<br>';
            echo $region = self::getRegionTitle($address);
            echo '<br>';
            echo $district = self::getDistrictTitle($address);
            echo '<br>';
            echo $city = self::getCityTitle($address);
            echo '<br>';

            $city = self::getCity($country_code, $region, $district, $city);
            echo $city->id . '<br>';
            echo '<br>';

            return $city;
        } else {
            return null;
        }
    }

    private function getCity($country_code, $region_title, $district_title, $city_title)
    {
        $country = self::getCountry($country_code);
        if (empty($country))
            return null;

        $region = self::getRegion($country, $region_title);
        $district = self::getDistrict($region, $district_title);

        return GeoCity::model()->findByAttributes(array(
            'country_id' => $country->id,
            'region_id' => empty($region) ? null : $region->id,
            'district_id' => empty($district) ? null : $district->id,
            'name' => $city_title
        ));
    }

    /**
     * @param $region
     * @param $district_title
     * @return GeoDistrict|null
     */
    private function getDistrict($region, $district_title)
    {
        if (empty($district_title))
            return null;

        $district_title = str_replace('район', '', $district_title);
        $district_title = trim($district_title);

        return GeoDistrict::model()->findByAttributes(array(
            'region_id' => ($region === null) ? null : $region->id,
            'name' => $district_title
        ));
    }

    /**
     * @param GeoCountry $country
     * @param $region_title
     * @return GeoCountry|null
     */
    private function getRegion($country, $region_title)
    {
        if (empty($region_title))
            return null;

        $region_title = str_replace('город ', '', $region_title);
        $region_title = trim($region_title);

        return GeoRegion::model()->findByAttributes(array('country_id' => $country->id, 'name' => $region_title));
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
        return self::getAddressComponent($address, 'administrative_area_level_1');
    }

    /**
     * Returns district title, like 'район Дубовский' or 'город Волгоград'
     *
     * @param $address
     * @return string
     */
    private function getDistrictTitle($address)
    {
        return self::getAddressComponent($address, 'administrative_area_level_2');
    }

    /**
     * Returns city title
     *
     * @param $address
     * @return string
     */
    private function getCityTitle($address)
    {
        return self::getAddressComponent($address, 'locality');
    }

    /**
     * Returns some address component
     *
     * @param $address
     * @param $type
     * @param string $name
     * @return string
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

        var_dump($addresses);

        return null;
    }
}
