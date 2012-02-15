<?php

class GeoController extends Controller
{
    public $layout = '//layouts/main';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionP()
    {
        /*$ountries = Countries::model()->findAll();
        foreach($ountries as $country){
            $c = new GeoCountry;
            $c->name = $country->rus_name;
            $c->pos = $country->population;
            if (!$c->save()){
                throw new CHttpException(404, 'Not saved!');
            }
        }*/
        /*$countries = GeoCountry::model()->findAll(array('order'=>'pos DESC'));
        $i = 100;
        foreach($countries as $c){
            $c->pos = $i;
            if (!$c->save()){
                throw new CHttpException(404, 'Not saved!');
            }
            $i++;
        }*/
        $countries = Countries::model()->findAll();
        foreach ($countries as $country) {
            $c = GeoCountry::model()->find('name="' . $country->rus_name . '"');
            $c->iso_code = $country->iso_code;
            if (!$c->save()) {
                throw new CHttpException(404, 'Not saved!');
            }
        }
    }

    public function actionCountries()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $countries = GeoCountry::model()->findAll(array(
                'condition' => 'name LIKE :term',
                'params' => array(':term' => $_GET['term'] . '%'),
            ));

            $_countries = array();
            foreach ($countries as $country)
            {
                $_countries[] = array(
                    'label' => $country->name,
                    'value' => $country->name,
                    'id' => $country->id,
                );
            }
            echo CJSON::encode($_countries);
        }
    }

    public function actionCities()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (empty($_GET['district_id']))
                $cities = GeoRusSettlement::model()->findAll(array(
                    'condition' => 'name LIKE :term AND region_id = :region_id AND district_id is null',
                    'params' => array(
                        ':term' => $_GET['term'] . '%',
                        ':region_id' => $_GET['region_id'],
                    ),
                    'limit' => 10,
                    'order' => 'population desc',
                ));
            else
                $cities = GeoRusSettlement::model()->findAll(array(
                    'condition' => 'name LIKE :term AND region_id = :region_id AND district_id = :district_id',
                    'params' => array(
                        ':term' => $_GET['term'] . '%',
                        ':region_id' => $_GET['region_id'],
                        ':district_id' => $_GET['district_id']
                    ),
                    'limit' => 10,
                    'order' => 'population, id',
                ));

            $_cities = array();
            foreach ($cities as $city)
            {
                $_cities[] = array(
                    'label' => $city->name,
                    'value' => $city->name,
                    'id' => $city->id,
                );
            }
            echo CJSON::encode($_cities);
        }
    }

    public function actionStreet()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if ($_GET['city_id'] == 148315 || $_GET['city_id'] == 148316) {
                $city = $this->loadSettlment($_GET['city_id']);
                $settlement_ids = Yii::app()->db->createCommand()
                    ->select('id')
                    ->from('geo_rus_settlement')
                    ->where('region_id = :region_id', array(':region_id' => $city->region_id))
                    ->queryColumn();

                $criteria = new CDbCriteria;
                $criteria->compare('settlement_id', $settlement_ids);
                $criteria->compare('name', $_GET['term'].'%', true, 'AND', false);
                $criteria->limit = 10;
                $models = GeoRusStreet::model()->findAll($criteria);
            }
            else
                $models = GeoRusStreet::model()->findAll(array(
                    'condition' => 'name LIKE :term AND settlement_id = :settlement_id',
                    'params' => array(
                        ':term' => $_GET['term'] . '%',
                        ':settlement_id' => $_GET['city_id'],
                    ),
                    'limit' => 10,
                ));

            $_cities = array();
            foreach ($models as $model)
            {
                $_cities[] = array(
                    'label' => $model->name,
                    'value' => $model->name,
                    'id' => $model->id,
                );
            }
            echo CJSON::encode($_cities);
        }
    }

    public function actionDistricts()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $cities = GeoRusDistrict::model()->findAll(array(
                'condition' => 'region_id = :region_id',
                'params' => array(
                    ':region_id' => Yii::app()->request->getPost('region_id'),
                ),
            ));

            echo CHtml::listOptions('', array('' => '') + CHtml::listData($cities, 'id', 'name'), $null);
        }
    }

    /**
     * @param int $id model id
     * @return GeoRusSettlement
     * @throws CHttpException
     */
    public function loadSettlment($id){
        $model = GeoRusSettlement::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
