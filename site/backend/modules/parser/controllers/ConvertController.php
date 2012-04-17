<?php

Yii::import('site.frontend.modules.geo.models.*');

class ConvertController extends BController
{
    private $country_id = 174;
    private $regions = array();

    public function actionIndex()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery.phpQuery');

        $i = 0;
        $models = array(1);
        $prev_region = '';
        $prev_region_id = null;
        $prev_district = '';
        $prev_district_id = null;


        while (!empty($models)) {
            $criteria = new CDbCriteria;
            $criteria->offset = 1000 * $i;
            $criteria->limit = 1000;
            $criteria->order = 'id';
            $criteria->condition = ' text != "" AND active = 1 ';
            $models = WeatherTemp::model()->findAll($criteria);
            $i++;

            foreach ($models as $model)
                if ($model !== null && !empty($model->name)) {
                    if (empty($model->text)) {
                        $city = GeoCity::model()->findAll(' name = "' . $model->name . '" AND country_id = ' . $this->country_id);
                        if (count($city) == 1) {
                            echo $model->name . ' нашли город <br>';
                            $city[0]->weather_id = $model->link;
                            $city[0]->save();
                            $model->delete();
                        } else {
                            echo $model->name . ' НЕ НАШЛИ город<br>';
                            $model->delete();
                        }
                    } else {
                        $text = trim(str_replace('Погода в ', '', $model->text));
                        $text = trim(str_replace('Погода во ', '', $text));
                        $text = trim(str_replace('Погода на ', '', $text));

                        if (strstr($text, ' районе')) {
                            if ($text == $prev_district) {

                            } else {
                                $prev_district = $text;

                                $text = trim(str_replace('районе', '', $text));
                                $text = substr($text, 0, strlen($text) - 4);
                                $districts = GeoDistrict::model()->findAll('name LIKE "' . $text . '%"');
                                if (count($districts) == 1) {
                                    $prev_district_id = $districts[0]->id;
                                } else {
                                    $html = $this->loadPage('http://rp5.ru' . $model->link);
                                    $document = phpQuery::newDocument($html);
                                    $region = $document->find('div.intoLeftNavi span.verticalBottom a:eq(2)')->text();
                                    if ($region == 'Еврейская АО') $region= 'Еврейская автономная область';
                                    if ($region == 'Республика Северная Осетия-Алания') $region= 'Республика Северная Осетия - Алания';

                                    if (!empty($region))
                                        $region = GeoRegion::model()->find('name LIKE "' . $region . '"');
                                    else
                                        $region = false;

                                    if ($region) {
                                        $district = GeoDistrict::model()->find('name LIKE "' . $text . '%" AND region_id=' . $region->id);
                                        if ($district)
                                            $prev_district_id = $district->id;
                                        else
                                            $prev_district_id = null;
                                    } else {
                                        echo $text . ' ' . $model->link . ' район НЕ НАЙДЕН<br>';
                                        $prev_district_id = null;
                                    }
                                }
                            }

                            if ($prev_district_id !== null) {
                                $city = GeoCity::model()->find(' name = "' . $model->name . '" AND district_id =' . $prev_district_id . ' AND country_id = ' . $this->country_id);
                                if ($city) {
                                    $city->weather_id = $model->link;
                                    $city->save();
                                    $model->delete();
                                }
                            }
                        }
                        else {
                            //регион
                            /*$text = $this->trimRegion($text);
                            if ($text == 'Омская область')
                                $region = GeoRegion::model()->count('name LIKE "' . $text . '%"');
                            else
                                $region = GeoRegion::model()->count('name LIKE "%' . $text . '%"');

                            if ($region != 1) {
                                $city = GeoCity::model()->findAll(' name = "' . $model->name . '" AND country_id = ' . $this->country_id);
                                if (count($city) == 1) {
                                    $city[0]->weather_id = $model->link;
                                    $city[0]->save();
                                    $model->delete();
                                }
                                echo $text . ' регион НЕ НАЙДЕН<br>';
                            }
                            else {
                                $region = GeoRegion::model()->find('name LIKE "%' . $text . '%"');

                                $city = GeoCity::model()->findAll(' name = "' . $model->name . '" AND region_id = ' . $region->id . ' AND district_id IS NULL AND country_id = ' . $this->country_id);
                                if (count($city) == 1) {
                                    $city[0]->weather_id = $model->link;
                                    $city[0]->save();
                                    $model->delete();
                                } elseif (count($city) > 1) {
                                    $city = GeoCity::model()->findAll(' name = "' . $model->name . '" AND region_id = ' . $region->id . ' AND country_id = ' . $this->country_id);
                                    if (count($city) == 1) {
                                        $city[0]->weather_id = $model->link;
                                        $city[0]->save();
                                        $model->delete();
                                    }
                                }
                            }*/
                        }
                    }
                }
            flush();
        }

    }

    public function actionRemoveEmpty()
    {
        $models = array(1);
        $j = 0;
        while (!empty($models)) {
            $criteria = new CDbCriteria;
            $criteria->offset = 1000 * $j;
            $criteria->limit = 1000;
            $criteria->order = 'id';
            $models = WeatherTemp::model()->findAll($criteria);

            foreach ($models as $model) {
                $repeat = WeatherTemp::model()->count('link = "' . $model->link . '"');
                if ($repeat > 1) {
                    $repeats = WeatherTemp::model()->findAll('link = "' . $model->link . '" order by id asc');
                    for ($i = 1; $i < count($repeats); $i++) {
                        $repeats[$i]->delete();
                    }
                }
            }

            $j++;
        }
    }

    public function trimRegion($name)
    {
        $parts = array('крае', 'области', 'АО', 'автономном округе', 'Республике');
        $name = preg_replace('#\(.*?\)#', '', $name);

        foreach ($parts as $part) {
            $name = str_replace($part, '', $name);
        }
        $name = trim($name);
        if (strlen($name) > 16)
            $name = substr($name, 0, strlen($name) - 4);
        else {
            if (substr($name, -4) == 'ой')
                $name = substr($name, 0, strlen($name) - 4) . 'ая';
            elseif (substr($name, -4) == 'ом')
                $name = substr($name, 0, strlen($name) - 4) . 'ий';
            elseif (substr($name, -4) == 'ии')
                $name = substr($name, 0, strlen($name) - 4) . 'ия';
            elseif (substr($name, -6) == 'ане')
                $name = substr($name, 0, strlen($name) - 6) . 'ан';
            elseif (substr($name, -4) == 'не')
                $name = substr($name, 0, strlen($name) - 4) . 'ня';
            elseif (substr($name, -4) == 'ее')
                $name = substr($name, 0, strlen($name) - 4) . 'ея';
        }

        if ($name == 'Камчатке') $name = 'Камчат';
        if ($name == 'Омская') $name = 'Омская область';
        if ($name == 'Приморье') $name = 'Приморский';
        if ($name == 'Алтае') $name = 'Республика Алтай';
        if ($name == 'Сахе') $name = 'Республика Саха';
        if ($name == 'Сахалиня') $name = 'Сахалин';
        if ($name == 'Северной Осетии-Алан') $name = 'Северная Осетия';
        if ($name == 'Тыве') $name = 'Тыва';
        if ($name == 'Удмуртия') $name = 'Удмурт';
        if ($name == 'Чечня') $name = 'Чечен';
        if ($name == 'Чувашия') $name = 'Чуваш';
        if ($name == 'Москве') $name = 'Москва';
        if ($name == 'Ненецкий') $name = 'Ненецкий автономный округ';


        return $name;
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

    public function actionParseFias()
    {
        $res = Yii::app()->db->createCommand()
            ->select('*')
            ->from('addr')
            ->where('AOLEVEL = 1')
            ->queryAll();

        foreach ($res as $r) {
            $region = new GeoRegion();
            $region->country_id = $this->country_id;
            $region->name = trim($r['FORMALNAME']);
            $region->type = trim($r['SHORTNAME']);
            if (!$region->save()) {
                var_dump($region->getErrors());
                Yii::app()->end();
            }

            $districts = Yii::app()->db->createCommand()
                ->select('*')
                ->from('addr')
                ->where('PARENTGUID = "' . $r['AOGUID'] . '"')
                ->queryAll();
            foreach ($districts as $district) {
                if ($district['SHORTNAME'] == 'р-н') {
                    $dist = new GeoDistrict();
                    $dist->name = trim($district['FORMALNAME']);
                    $dist->region_id = $region->id;
                    $dist->save();

                    $settlements = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('addr')
                        ->where('PARENTGUID = "' . $district['AOGUID'] . '"')
                        ->queryAll();
                    foreach ($settlements as $settlement) {
                        $city = new GeoCity();
                        $city->country_id = $this->country_id;
                        $city->name = trim($settlement['FORMALNAME']);
                        $city->region_id = $region->id;
                        $city->district_id = $dist->id;
                        $city->type = trim($settlement['SHORTNAME']);
                        $city->save();
                    }
                } else {
                    $city = new GeoCity();
                    $city->country_id = $this->country_id;
                    $city->name = trim($district['FORMALNAME']);
                    $city->region_id = $region->id;
                    $city->type = trim($district['SHORTNAME']);
                    $city->save();
                }
            }
        }
    }
}