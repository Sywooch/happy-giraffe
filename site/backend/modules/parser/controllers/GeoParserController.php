<?php

class GeoParserController extends BController
{
    private $country_id = 109;

    public function actionIndex()
    {
        /*Yii::import('site.frontend.modules.geo.models.*');
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
        }*/
    }

    public function actionKaz()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.extensions.phpQuery.phpQuery.phpQuery');

        $host = 'http://kazindex.ru/';
        $html = $this->loadPage($host);
        $document = phpQuery::newDocument(trim($html));
        foreach ($document->find('body center table center table a') as $link) {
            $main_url = pq($link)->attr('href');
            $name = pq($link)->text();
            echo "{$main_url} - {$name} <br>";

            $region = new GeoRegion();
            $region->country_id = $this->country_id;
            $region->name = trim($name);
            $region->save();

            $html = $this->loadPage($host . $main_url);
            $document2 = phpQuery::newDocument(trim($html));
            $title = $document2->find('h1:first')->text();
            if (strstr($title, 'Город')) {
                echo $title;
                $city = new GeoCity();
                $city->country_id = $this->country_id;
                $city->name = $name;
                $city->region_id = $region->id;
                $city->save();

                foreach ($document2->find('body center table center table tr td') as $elem) {
                    preg_match('/(\d{6})/', pq($elem)->text(), $match);
                    if (isset($match[1])) {
                        $zip = $match[1];
                        echo $zip . '<br>';

                        $geoZip = new GeoZip();
                        $geoZip->city_id = $city->id;
                        $geoZip->code = trim($zip);
                        $geoZip->save();
                    }
                }
            } else {
                foreach ($document2->find('body center table center table a') as $distr_link) {
                    $url = pq($distr_link)->attr('href');
                    $name = pq($distr_link)->text();
                    echo "{$url} - {$name} <br>";

                    $district = new GeoDistrict();
                    $district->name = $name;
                    $district->region_id = $region->id;
                    $district->save();

                    $html = $this->loadPage($host . str_replace('0.html', $url, $main_url));
                    $document3 = phpQuery::newDocument(trim($html));
                    foreach ($document3->find('body center table center table tr td') as $elem) {
                        preg_match('/([^\s^\d^-]+)/', pq($elem)->text(), $match);
                        if (isset($match[0])) {
                            echo $match[0].'<br>';
                            $city_name = trim($match[0]);

                            if (!empty($city_name)){
                            $city = GeoCity::model()->findByAttributes(array(
                                'name' => $city_name,
                                'region_id' => $region->id,
                                'district_id' => $district->id,
                            ));
                            if ($city === null) {
                                $city = new GeoCity();
                                $city->country_id = $this->country_id;
                                $city->name = $city_name;
                                $city->region_id = $region->id;
                                $city->district_id = $district->id;
                                $city->save();
                            }

                            preg_match('/(\d{6})/', pq($elem)->text(), $match);
                            if (isset($match[1])) {
                                $zip = $match[1];
                                echo $zip . '<br>';

                                $geoZip = new GeoZip();
                                $geoZip->city_id = $city->id;
                                $geoZip->code = trim($zip);
                                $geoZip->save();
                            }
                        }
                        }
                    }
                }
            }
        }
    }

    public function actionParseBelarus()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.extensions.phpQuery.phpQuery.phpQuery');

        $host = 'http://zip.belpost.by/';
        $html = $this->loadPage($host);
        $document = phpQuery::newDocument(trim($html));
        foreach ($document->find('.name_obj a') as $option) {
            $url = pq($option)->attr('href');
            $name = pq($option)->text();

            $obl = pq($option)->parent()->parent()->prev('strong')->text();
            if (empty($obl))
                $obl = pq($option)->parent()->parent()->prev()->prev('strong')->text();
            $obl = mb_strtolower($obl, 'UTF-8');
            $obl = mb_convert_case($obl, MB_CASE_TITLE, 'UTF-8');
            $obl = trim(str_replace('Область', 'обл.', $obl));

            echo "{$url} - {$name}  {$obl} <br>";

            $region = GeoRegion::model()->find('name="' . $obl . '"');
            if ($region === null) {
                $region = new GeoRegion();
                $region->country_id = $this->country_id;
                $region->name = $obl;
                $region->save();
            }

            if ($this->startsWith($url, '/city/')) {
                $city = new GeoCity();
                $city->country_id = $this->country_id;
                $city->name = $name;
                $city->region_id = $region->id;
                $city->save();

                $html = $this->loadPage($host . $url);
                $document = phpQuery::newDocument(trim($html));
                foreach ($document->find('.tblcity a') as $link) {
                    $zip_url = pq($link)->attr('href');
                    $zip = pq($link)->text();

                    if (strstr($zip_url, 'zip_code')) {
                        $geoZip = new GeoZip();
                        $geoZip->city_id = $city->id;
                        $geoZip->code = trim($zip);
                        $geoZip->save();
                    }
                }
            } else {
                $district = new GeoDistrict();
                $district->name = $name;
                $district->region_id = $region->id;
                $district->save();

                $html = $this->loadPage($host . $url);
                $document = phpQuery::newDocument(trim($html));
                foreach ($document->find('.tblcity tr') as $tr) {
                    $name = trim(pq($tr)->find('td:first a')->attr('title'));
                    $zip = trim(pq($tr)->find('td:eq(1) a')->text());

                    if (!empty($name)) {
                        $city = GeoCity::model()->findByAttributes(array(
                            'name' => $name,
                            'region_id' => $region->id,
                            'district_id' => $district->id,
                        ));
                        if ($city === null) {
                            $city = new GeoCity();
                            $city->country_id = $this->country_id;
                            $city->name = $name;
                            $city->region_id = $region->id;
                            $city->district_id = $district->id;
                            $city->save();
                        }

                        if (!empty($zip)) {
                            $geoZip = new GeoZip();
                            $geoZip->city_id = $city->id;
                            $geoZip->code = trim($zip);
                            $geoZip->save();
                        }
                    }
                }
            }
            flush();
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
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
//        curl_setopt($curl, CURLOPT_PROXY, '176.196.169.3:8080');

        $html = curl_exec($curl); // execute the curl command
        curl_close($curl); // close the connection

//        return $html;
        return $this->CP1251toUTF8($html);
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
        $xml = simplexml_load_file(Yii::app()->getBasePath() . '/fias_xml/AS_ADDROBJ_20120307_ed70af27-1091-4bff-98fc-8030bcb87d22.XML');
    }
}