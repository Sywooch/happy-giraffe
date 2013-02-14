<?php
/**
 * Author: alexk984
 * Date: 25.01.13
 */
class GoogleMapsGeoCode extends CComponent
{
    public function getObjectNameByCoordinates($lat, $lng)
    {
        Yii::import('site.frontend.modules.geo.models.*');

        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&sensor=true&language=ru';

        $text = file_get_contents($url);
        $result = json_decode($text, true);
        if (isset($result['status']) && $result['status'] == 'OK') {
            $address = self::getAddressComponentsByType($result['results']);

            if ($address === null) {
                return $result['results'][0]['formatted_address'];
            }

            return $this->getAddressComponent($address, 'locality');
        } else {
            return null;
        }
    }

    public function loadPage($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXY, '95.211.189.218:46199;');

        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexhg:Nokia1111");
        curl_setopt($ch, CURLOPT_PROXYAUTH, 1);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * @param $lat
     * @param $lng
     * @return null|GeoCity
     */
    public function getCityByCoordinates($lat, $lng)
    {
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&sensor=true&language=ru';

//        $text = file_get_contents($url);
        $text = $this->loadPage($url);
        $result = json_decode($text, true);

        if (isset($result['status']) && $result['status'] == 'OK') {

            $address = self::getAddressComponentsByType($result['results']);
            if ($address === null)
                return null;

            $country_code = self::getCountryCode($address);
            $region = self::getRegionTitle($address);
            $district = self::getDistrictTitle($address);
            $city = self::getCityTitle($address);

            $city = self::getCity($country_code, $region, $district, $city);

            return $city;
        } else {
            echo $result['status'];
            return null;
        }
    }

    private function getCity($country_code, $region_title, $district_title, $city_title)
    {
        $country = self::getCountry($country_code);
        if (empty($country))
            return null;

        if ($region_title == $city_title)
            $region = self::getRegion($country, $region_title, 'г');
        else
            $region = self::getRegion($country, $region_title);

        if (strpos($district_title, 'город ') === 0)
            $district = null;
        else
            $district = self::getDistrict($region, $district_title);

        $city = GeoCity::model()->findByAttributes(array(
            'country_id' => $country->id,
            'region_id' => empty($region) ? null : $region->id,
            'district_id' => empty($district) ? null : $district->id,
            'name' => $city_title
        ));
        if ($city === null) {
            $city = new GeoCity();
            $city->country_id = $country->id;
            $city->region_id = $region->id;
            if (!empty($district))
                $city->district_id = $district->id;
            $city->name = $city_title;
            $city->auto_created = 1;
            if (!$city->save())
                var_dump($city->getErrors());

            return $city;
        }
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

        $isCity = false;
        if (strpos($region_title, 'город ') !== false) {
            $region_title = str_replace('город ', '', $region_title);
            $isCity = true;
        }
        $region_title = trim($region_title);

        $region = GeoRegion::model()->findByAttributes(array('country_id' => $country->id, 'name' => $region_title));
        if ($region === null) {
            $region = new GeoRegion;
            $region->country_id = $country->id;
            $region->position = 1000;
            $region->name = $region_title;
            $region->auto_created = 1;
            if ($isCity)
                $region->type = 'г';
            else {
                if (!empty($type))
                    $region->type = $type;
            }
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
        $city = self::getAddressComponent($address, 'locality');
        if (strpos($city, 'г.') === 0)
            $city = str_replace('г. ', '', $city);
        return $city;
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

        return null;
    }
}
