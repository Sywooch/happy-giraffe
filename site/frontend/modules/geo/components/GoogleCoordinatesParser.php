<?php
/**
 * Author: alexk984
 * Date: 23.01.13
 */

class GoogleCoordinatesParser
{
    /**
     * @var SeoCityCoordinates
     */
    public $coordinates;
    /**
     * @var GeoCity
     */
    private $city;
    private $proxy;
    private $debug_mode = false;
    private $use_proxy;

    public function __construct($debug_mode = false, $use_proxy = false)
    {
        $this->debug_mode = $debug_mode;
        $this->use_proxy = $use_proxy;
    }

    public function start()
    {
        Yii::import('site.seo.models.*');
        time_nanosleep(rand(0, 60), rand(0, 1000000000));
        $this->changeProxy();

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
            if ($result['status'] == 'ZERO_RESULTS') {
                $this->log('status: ' . $result['status'] . ' - ' . $this->proxy);
                echo $this->city->id . "\n";
            } else {
                $this->log('status: ' . $result['status'] . ' - ' . $this->proxy);
                $this->changeProxy();
                if ($attempt > 50) {
                    var_dump($text);
                    Yii::app()->end();
                }

                $attempt++;
                $this->parseCity($attempt);
            }
        }
    }

    public function loadPage($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
        curl_setopt($ch, CURLOPT_URL, $url);

        if ($this->use_proxy) {
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);

            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexhg:Nokia1111");
            curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result === false) {
            $this->changeProxy();
            return $this->loadPage($url);
        }

        return $result;
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

    public function changeProxy()
    {
        if ($this->use_proxy) {
            $list = $this->getProxyList();
            $this->proxy = $list[rand(0, count($list) - 1)];
        }
    }

    public function getProxyList()
    {
        $cache_id = 'proxy_list';
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            $file = file_get_contents('http://awmproxy.com/allproxy.php?country=1');

            //select only rus proxy
            preg_match_all('/([\d:\.]+);/', $file, $matches);
            $value = array();
            for ($i = 0; $i < count($matches[0]); $i++) {
                $value[] = $matches[1][$i];
            }

            Yii::app()->cache->set($cache_id, $value, 30000);
        }

        return $value;
    }

    public function log($str)
    {
        if ($this->debug_mode)
            echo $str . "\n";
    }
}