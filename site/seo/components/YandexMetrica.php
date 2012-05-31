<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */
class YandexMetrica
{
    public $token = 'b1cb78403f76432b8a6803dc5e6631b5';
    public $min_clicks = 4;

    public function getData()
    {
        $this->loadPage('/stat/sources/phrases?id=11221648&oauth_token=' . $this->token . '&per_page=100&filter=month&date1=20120430&date2=20120531&select_period=month');
    }

    private function loadPage($url)
    {
        $hostname = 'api-metrika.yandex.ru';
        $ch = curl_init('http://' . $hostname . $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/x-yametrika+json'));
        curl_exec($ch);
        $result = curl_exec($ch);
        $val = json_decode($result, true);
        foreach ($val['data'] as $query) {
            echo $query['phrase'] . ' ' . $query['visits'];
            foreach ($query['search_engines'] as $search_engine) {
                echo ' .' . $search_engine['se_page'];
            }
            echo '<br>';
        }
        curl_close($ch);

        return $result;
    }
}
