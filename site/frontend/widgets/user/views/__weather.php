<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 */

class SimpleGooWeather {
    public $xml;

    function __construct($city, $lang="ru", $charset="utf-8"){
        $base = 'http://www.google.com/ig/api';
        $params = "weather=" . trim($city);
        $params .= "&hl=" . trim($lang);
        $params .= "&oe=" . trim($charset);
        $url = $base . "?" . $params;
        $this->xml = simplexml_load_file($url);
    }

    function getInfo(){
        if(!$this->xml) return false;
        $information = $this->xml->xpath("/xml_api_reply/weather/forecast_information");
        if (!isset($information[0]))
            return false;
        return $information[0];
    }

    function getCurrentWeather(){
        if(!$this->xml) return false;
        $current = $this->xml->xpath("/xml_api_reply/weather/current_conditions");
        if (!isset($current[0]))
            return false;
        return $current[0];
    }

    function getForecast(){
        if(!$this->xml) return array();
        $forecast_list = $this->xml->xpath("/xml_api_reply/weather/forecast_conditions");
        return $forecast_list;
    }

}

$requestAddress = "http://www.google.com/ig/api?weather=".urlencode($this->user->getLocationString())."&hl=ru";
//echo $requestAddress.'<br><br>';
$gw = new SimpleGooWeather(urlencode($this->user->getLocationString()));
$gw_today = $gw->getCurrentWeather();
var_dump($gw_today);
/*// скачиваем данные о погоде
$xml_str = file_get_contents($requestAddress,0);
// парсим XML
$xml = new SimplexmlElement($xml_str);
// обрабатываем XML
$count = 0;
echo '<div id="weather">';
foreach($xml->weather as $item) {
   foreach($item->forecast_conditions as $new) {
       echo '<div class="weatherIcon">';
       echo '<img src="http://www.google.com/' .$new->icon['data'] . '"/><br/>';
       echo $new->day_of_week['data'];
       echo '</div>';
   }
}
echo '</div>';*/