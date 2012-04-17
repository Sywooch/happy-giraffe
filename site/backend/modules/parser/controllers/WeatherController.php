<?php
/**
 * Author: alexk984
 * Date: 27.03.12
 */

class WeatherController extends BController
{
    private $country_id = 174;

    public function actionIndex()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.extensions.phpQuery.phpQuery.phpQuery');

        $country = GeoCountry::model()->findByPk($this->country_id);
        $html = $this->loadPage('http://rp5.ru/map/3/0/0/ru');
        $host = 'http://rp5.ru';
        $document = phpQuery::newDocument($html);

        $all_links = array();
        $not_cities = array();
        foreach ($document->find('table.countryMap a') as $link) {
            $item_href = pq($link)->attr('href');
            $item_name = pq($link)->text();
            $dop_info = $document->find('h1')->text();

            if (substr_count($item_href, '/') == 2) {
                $this->AddCity(array($item_href, $item_name, $dop_info));
            } else
                $not_cities [] = $item_href;


            /*                echo "{$country_text} - {$region_link}, {$region_name} <br>";

            $criteria = new CDbCriteria;
            $criteria->compare('name', $region_name . '%', true);
            $region = GeoRegion::model()->find($criteria);
            if ($region !== null) {
                $html = $this->loadPage('http://rp5.ru' . $region_link);
                $region_document = phpQuery::newDocument($html);
                foreach ($region_document->find('.statTable tr') as $region_row) {

                }
            } else {
                echo 'Регион не найден ' . $region_name;
            }*/
        }
        //var_dump($all_links);

        $i = 0;
        while(isset($not_cities[$i])){
            $current = $not_cities[$i];
            //sleep(rand(3,5));
            $html = $this->loadPage($host.$current);
            $document = phpQuery::newDocument($html);
            foreach ($document->find('table.countryMap a') as $link) {
                $item_href = pq($link)->attr('href');
                $item_name = pq($link)->text();
                $dop_info = $document->find('h1')->text();

                if (substr_count($item_href, '/') == 2) {
                    $this->AddCity(array($item_href, $item_name, $dop_info));
                    //echo $item_name.'<br>';
                } else
                    $not_cities [] = $item_href;
            }

            $i++;
        }
    }

    public function AddCity($data)
    {
        Yii::app()->db->createCommand()
            ->insert('_weather_temp', array(
            'link'=>$data[0],
            'name'=>$data[1],
            'text'=>$data[2],
        ));
    }

    public function loadPage($url)
    {
        $curl = curl_init();

        // Setup headers - I used the same headers from Firefox version 2.0.0.6
        // below was split up because php.net said the line was too long. :/
        $header[0] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8;";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Content-Type: text/html; charset=windows-1251";
        $header[] = "Accept-Language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3";
        $header[] = "Pragma: "; // browsers keep this blank.

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
//        curl_setopt($curl, CURLOPT_PROXY, '176.196.169.3:8080');

        $html = curl_exec($curl); // execute the curl command
        curl_close($curl); // close the connection

        return $html;
//        return $this->CP1251toUTF8($html);
    }
}