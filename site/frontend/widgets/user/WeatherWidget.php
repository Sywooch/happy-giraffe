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
        if (!$this->user->getUserAddress()->hasCity())
            return ;
        $data = Yii::app()->cache->get('WeatherWidget_' . date("Y-m-d") . $this->user->getUserAddress()->getLocationString());
        if ($data == false) {
            $gw = new SimpleGoogleWeather(urlencode($this->user->getUserAddress()->getLocationString()));
            $gw_today = $gw->getCurrentWeather();
            if ($gw_today === false)
                return;

            $data = $this->render('WeatherWidget', array(
                'now_temp' => $gw->getNowTemp(),
                'now_condition' => $gw->getNowCondition(),
                'night' => $gw->getNightTemp(),
                'yesterday' => $gw->GetYesterdayTemp(),
                'data' => $gw->getForecastData()
            ), true);

            Yii::app()->cache->set('WeatherWidget_' . date("Y-m-d") . $this->user->getUserAddress()->getLocationString(), $data, 12000);
        }

        echo $data;
    }
}

class SimpleGoogleWeather
{
    public $xml;
    public $conditions = array(
        'Ясно' => 2,
        'Преимущественно солнечно' => 2,
        'Местами солнечно' => 1,
        'Переменная облачность' => 1,
        'Преимущественно облачно' => 1,
        'Облачно с прояснениями' => 2,
        'Сплошная облачность' => 2,
        'Переменная облачность' => 1,
        'Небольшой снег' => 4,
        'Возможен снег' => 4,
        'Снег' => 4,
        'Дождь' => 5,
        'Небольшой дождь' => 5,
        'Возможен дождь' => 5,
        'Дождь со снегом'=>5,
        'Дым' => 1,
        'Туман' => 1,
        'Изморозь' => 1,
        'Морось' => 1,
        'Дождь со снегом'=>1,
        'Ветер'=>6,
        'Буря'=>6,
        'Возможен шторм'=>6,
        'Гроза'=>7,
        'Гололед'=>5,
        'Град'=>5,
    );

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

    function getNowCondition()
    {
        $gw_today = $this->getCurrentWeather();

        $day_res = array();
        $attr = $gw_today->condition->attributes();
        $day_res['condition'] = $this->conditionToImage($attr['data']);
        $day_res['condition_title'] = $attr['data'];

        return $day_res;
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

    public function getForecastData()
    {
        $forecast = $this->getForecast();
        $res = array();
        foreach ($forecast as $day) {
            $day_res = array();
            $attr = $day->high->attributes();
            $day_res['high'] = $attr['data'];
            $attr = $day->low->attributes();
            $day_res['low'] = $attr['data'];
            $attr = $day->condition->attributes();
            $day_res['condition'] = $this->conditionToImage($attr['data']);
            $day_res['condition_title'] = $attr['data'];
            $res [] = $day_res;
        }

        return $res;
    }

    public function conditionToImage($condition)
    {
        $condition = (string)$condition;
        if (isset($this->conditions[$condition]))
            return $this->conditions[$condition];
        else
            return 1;
    }
}