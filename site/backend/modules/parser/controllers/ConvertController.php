<?php

Yii::import('site.frontend.modules.geo.models.*');

class ConvertController extends BController
{
    private $country_id = 174;

    public function actionIndex()
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
                }else{
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