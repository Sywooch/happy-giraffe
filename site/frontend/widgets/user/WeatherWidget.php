<?php
/**
 * Author: alexk984
 * Date: 02.03.12
 */
class WeatherWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $from_cache = Yii::app()->cache->get('WeatherWidget_' . $this->user->getLocationString());
        if ($from_cache === false) {
            $gw = new SimpleGoogleWeather(urlencode($this->user->getLocationString()));
            $gw_today = $gw->getCurrentWeather();
            if ($gw_today == false)
                return;

            $from_cache = $this->render('WeatherWidget', array(
                'now_temp' => $gw->getNowTemp(),
                'night' => $gw->getNightTemp(),
                'yesterday' => $gw->GetYesterdayTemp()
            ), true);
        }

        echo $from_cache;
    }
}

class SimpleGoogleWeather
{
    public $xml;

    function __construct($city, $lang = "ru", $charset = "utf-8")
    {
        $base = 'http://www.google.com/ig/api';
        $params = "weather=" . trim($city);
        $params .= "&hl=" . trim($lang);
        $params .= "&oe=" . trim($charset);
        $url = $base . "?" . $params;
        $this->xml = simplexml_load_file($url);
    }

    function getInfo()
    {
        if (!$this->xml) return false;
        $information = $this->xml->xpath("/xml_api_reply/weather/forecast_information");
        if (!isset($information[0]))
            return false;
        return $information[0];
    }

    function getCurrentWeather()
    {
        if (!$this->xml) return false;
        $current = $this->xml->xpath("/xml_api_reply/weather/current_conditions");
        if (!isset($current[0]))
            return false;
        return $current[0];
    }

    function getForecast()
    {
        if (!$this->xml) return array();
        $forecast_list = $this->xml->xpath("/xml_api_reply/weather/forecast_conditions");
        return $forecast_list;
    }

    function getNowTemp()
    {
        $gw_today = $this->getCurrentWeather();

        $attr = $gw_today->temp_c->attributes();
        return $attr['data'][0];
    }

    function getNightTemp()
    {
        $forecast = $this->getForecast();
        $attr = $forecast[0]->low->attributes();
        return $attr['data'];
    }

    function GetYesterdayTemp()
    {
        $forecast = $this->getForecast();
        $attr = $forecast[0]->high->attributes();
        return $attr['data'];
    }
}