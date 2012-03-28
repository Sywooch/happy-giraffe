<?php

Yii::import('site.frontend.modules.geo.models.*');

class ConvertController extends BController
{
    private $country_id = 174;
    private $regions = array();

    public function actionIndex()
    {
        $i = 0;
        $models = array(1);
        while (!empty($models)) {
            $criteria = new CDbCriteria;
            $criteria->offset = 1000*$i;
            $criteria->limit = 1000;
            $criteria->order = 'id';
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
                        }
                    } else {
                        $text = trim(str_replace('Погода в ', '', $model->text));
                        $text = trim(str_replace('Погода во ', '', $text));
                        $text = trim(str_replace('Погода на ', '', $text));

                        if (strstr($text, ' районе')) {
                            $text = trim(str_replace('районе', '', $text));
                            $name = mb_substr($text, 0, strlen($text) - 2);
                            $districts = GeoDistrict::model()->findAll('name LIKE "' . $name . '%"');
                            if (count($districts) == 1) {
                                $city = GeoCity::model()->findAll(' name = "' . $model->name . '" AND district_id =' . $districts[0]->id . ' AND country_id = ' . $this->country_id);
                                if (count($city) == 1) {
                                    $city[0]->weather_id = $model->link;
                                    $city[0]->save();
                                    $model->delete();
                                }
                            } else {
                                echo $text . ' район НЕ НАЙДЕН<br>';
                            }
                        } else {
                            //регион
                            $text = $this->trimRegion($text);
                            $region = GeoRegion::model()->count('name LIKE "%' . $text . '%"');
                            if ($region != 1)
                                echo $text . ' регион НЕ НАЙДЕН<br>';
                            $city = GeoCity::model()->findAll(' name = "' . $model->name . '" AND district_id IS NULL AND country_id = ' . $this->country_id);
                            if (count($city) == 1) {
                                $city[0]->weather_id = $model->link;
                                $city[0]->save();
                                $model->delete();
                            }else{
                                $city = GeoCity::model()->findAll(' name = "' . $model->name . '" AND country_id = ' . $this->country_id);
                                if (count($city) == 1) {
                                    $city[0]->weather_id = $model->link;
                                    $city[0]->save();
                                    $model->delete();
                                }
                            }
                        }
                    }
                }
            flush();
        }

        foreach ($this->regions as $region) {
            echo $region . '<br>';
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
        //$name = substr($name, 0, strlen($name) - 4);
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

        if (!in_array($name, $this->regions))
            $this->regions[] = $name;
        //echo $name . ' - регион<br>';

        return $name;
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