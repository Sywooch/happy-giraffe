<?php

class GeoParserController extends BController
{
    private $country_id = 20;

    public function actionIndex()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        $models = GeoCity::model()->findAll('country_id=' . $this->country_id);
        foreach ($models as $model) {
            $model->name = $this->utf8_to_cp1251($model->name);
            $model->save();
        }
        $models = GeoRegion::model()->findAll('country_id=' . $this->country_id);
        foreach ($models as $model) {
            $model->name = $this->utf8_to_cp1251($model->name);
            $model->save();
        }
        $models = GeoDistrict::model()->findAll();
        foreach ($models as $model) {
            $model->name = $this->utf8_to_cp1251($model->name);
            $model->save();
        }
    }

    public function actionParse()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.extensions.phpQuery.phpQuery.phpQuery');

        //for($obl = 1; $obl < 25; $obl++)
        $obl = 1;

        $url = 'http://weather-in.by/search.html?oblast=' . $obl . '&region=&town=';
        $html = $this->loadPage($url);
        $document = phpQuery::newDocument($html);
        foreach ($document->find('#oblast option') as $option) {
            $r_val = pq($option)->attr('value');
            $name = pq($option)->text();
            if (!empty($r_val)) {
                echo $r_val . ' - ' . $name . '<br>';
                $region = new GeoRegion();
                $region->country_id = $this->country_id;
                $region->name = trim($name);
                $region->save();

//                sleep(2);
                $url = 'http://weather-in.by/cgi-bin/weather.fcgi?module=search&action=getregions&lang=ru&oblast=' . $r_val;
                $html = $this->loadPage($url);

                preg_match_all('/([\d]+)[\s*\t*](.*)/', $html, $matches);
                for ($i = 0; $i < count($matches[0]); $i++) {
                    $d_val = trim($matches[1][$i]);
                    $name = trim($matches[2][$i]);
                    echo $d_val . ' - ' . $name . '<br>';

                    if (!empty($d_val)) {
                        if ($this->startsWith($name, 'г.')) {
                            $city = new GeoCity();
                            $city->country_id = $this->country_id;
                            $city->region_id = $region->id;
                            $name = trim($name, 'г.');
                            $city->name = trim($name);
                            $city->save();
                        } else {
                            $district = new GeoDistrict();
                            $district->region_id = $region->id;
                            $district->name = $name;
                            $district->save();

//                            sleep(2);

                            $url = 'http://weather-in.by/search.html?oblast=' . $r_val . '&region=' . $d_val . '&town=';
                            $html = $this->loadPage($url);
                            $document = phpQuery::newDocument($html);

                            foreach ($document->find('div.listfield div.column div.list ul.list li a') as $city_el) {
                                $name = pq($city_el)->text();

                                $city = new GeoCity();
                                $city->country_id = $this->country_id;
                                $city->region_id = $region->id;
                                $city->district_id = $district->id;
                                $city->name = trim($name);
                                $city->save();
                            }

                        }
                    }
                }
                flush();
            }
        }
    }

    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
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
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);

        $html = curl_exec($curl); // execute the curl command
        curl_close($curl); // close the connection

        return $html;
        //return $this->CP1251toUTF8($html);
    }

    function CP1251toUTF8($string)
    {
        $out = '';
        for ($i = 0; $i < strlen($string); ++$i) {
            $ch = ord($string{$i});
            if ($ch < 0x80) $out .= chr($ch);
            else
                if ($ch >= 0xC0)
                    if ($ch < 0xF0)
                        $out .= "\xD0" . chr(0x90 + $ch - 0xC0); // А-Я, а-п (A-YA, a-p)
                    else $out .= "\xD1" . chr(0x80 + $ch - 0xF0); // р-я (r-ya)
                else
                    switch ($ch) {
                        case 0xA8:
                            $out .= "\xD0\x81";
                            break; // YO
                        case 0xB8:
                            $out .= "\xD1\x91";
                            break; // yo
// ukrainian
                        case 0xA1:
                            $out .= "\xD0\x8E";
                            break; // Ў (U)
                        case 0xA2:
                            $out .= "\xD1\x9E";
                            break; // ў (u)
                        case 0xAA:
                            $out .= "\xD0\x84";
                            break; // Є (e)
                        case 0xAF:
                            $out .= "\xD0\x87";
                            break; // Ї (I..)
                        case 0xB2:
                            $out .= "\xD0\x86";
                            break; // I (I)
                        case 0xB3:
                            $out .= "\xD1\x96";
                            break; // i (i)
                        case 0xBA:
                            $out .= "\xD1\x94";
                            break; // є (e)
                        case 0xBF:
                            $out .= "\xD1\x97";
                            break; // ї (i..)
// chuvashian
                        case 0x8C:
                            $out .= "\xD3\x90";
                            break; // Ӑ (A)
                        case 0x8D:
                            $out .= "\xD3\x96";
                            break; // Ӗ (E)
                        case 0x8E:
                            $out .= "\xD2\xAA";
                            break; // Ҫ (SCH)
                        case 0x8F:
                            $out .= "\xD3\xB2";
                            break; // Ӳ (U)
                        case 0x9C:
                            $out .= "\xD3\x91";
                            break; // ӑ (a)
                        case 0x9D:
                            $out .= "\xD3\x97";
                            break; // ӗ (e)
                        case 0x9E:
                            $out .= "\xD2\xAB";
                            break; // ҫ (sch)
                        case 0x9F:
                            $out .= "\xD3\xB3";
                            break; // ӳ (u)
                    }
        }
        return $out;
    }

    function utf8_to_cp1251($utf8)
    {

        $windows1251 = "";
        $chars = preg_split("//", $utf8);

        for ($i = 1; $i < count($chars) - 1; $i++) {
            $prefix = ord($chars[$i]);
            $suffix = ord($chars[$i + 1]);

            if ($prefix == 215) {
                $windows1251 .= chr($suffix + 80);
                $i++;
            } elseif ($prefix == 214) {
                $windows1251 .= chr($suffix + 16);
                $i++;
            } else {
                $windows1251 .= $chars[$i];
            }
        }

        return $windows1251;
    }

    public function actionFias()
    {
        $xml = simplexml_load_file(Yii::app()->getBasePath().'/fias_xml/AS_ADDROBJ_20120307_ed70af27-1091-4bff-98fc-8030bcb87d22.XML');

    }
}