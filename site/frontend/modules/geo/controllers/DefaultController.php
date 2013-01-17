<?php

class DefaultController extends HController
{
    public $layout = '//layouts/main';

    public function filters()
    {
        return array(
            'accessControl',
            'countries,regions,cities,street,saveLocation,regionIsCity + ajaxOnly'
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionRegions()
    {
        $id = Yii::app()->request->getPost('id');
        $_regions = array();
        if (!empty($id)) {
            $criteria = new CDbCriteria;
            $criteria->compare('country_id', $id);
            $criteria->order = 'position asc, name asc';
            $regions = GeoRegion::model()->findAll($criteria);

            if (empty($regions)) {

            } else {
                foreach ($regions as $region) {
                    $_regions[] = array($region->id, $region->name);
                }
                echo CHtml::listOptions(null, array('' => 'Регион') + CHtml::listData($regions, 'id', 'name'), $null);
            }
        } else
            echo '';
    }

    public function actionCities()
    {
        $term = $_GET['term'];
        $filter_parts = FilterParts::model()->findAll();
        foreach ($filter_parts as $filter_part) {
            $term = str_replace($filter_part->part . ' ', '', $term);
        }
        $term = trim($term);

        $cities = GeoCity::model()->findAll(array(
            'condition' => 't.name LIKE :term AND t.region_id = :region_id',
            'params' => array(
                ':term' => $term . '%',
                ':region_id' => $_GET['region_id'],
            ),
            'limit' => 10,
            'with' => array(
                'district'
            )
        ));

        $_cities = array();
        foreach ($cities as $city) {
            $showDistrict = false;
            foreach ($cities as $city2) {
                if ($city2->name == $city->name && $city2->id != $city->id)
                    $showDistrict = true;
            }
            if ($showDistrict)
                $label = $city->district ? $city->name . ' (' . $city->district->name . ' р-н)' : $city->name;
            else
                $label = $city->name;

            $_cities[] = array(
                'label' => $label,
                'value' => $city->name,
                'id' => $city->id,
            );
        }
        echo CJSON::encode($_cities);
    }

    public function actionStreet()
    {
        if ($_GET['city_id'] == 148315 || $_GET['city_id'] == 148316) {
            $city = $this->loadSettlment($_GET['city_id']);
            $settlement_ids = Yii::app()->db->createCommand()
                ->select('id')
                ->from('geo_rus_settlement')
                ->where('region_id = :region_id', array(':region_id' => $city->region_id))
                ->queryColumn();

            $criteria = new CDbCriteria;
            $criteria->compare('settlement_id', $settlement_ids);
            $criteria->compare('name', $_GET['term'] . '%', true, 'AND', false);
            $criteria->limit = 10;
            $models = GeoRusStreet::model()->findAll($criteria);
        } else
            $models = GeoRusStreet::model()->findAll(array(
                'condition' => 'name LIKE :term AND settlement_id = :settlement_id',
                'params' => array(
                    ':term' => $_GET['term'] . '%',
                    ':settlement_id' => $_GET['city_id'],
                ),
                'limit' => 10,
            ));

        $_cities = array();
        foreach ($models as $model) {
            $_cities[] = array(
                'label' => $model->name,
                'value' => $model->name,
                'id' => $model->id,
            );
        }
        echo CJSON::encode($_cities);
    }

    public function actionLocationForm()
    {
        $user = Yii::app()->user->getModel();
        Yii::app()->clientScript->scriptMap = array(
            'jquery.js' => false,
            'jquery.min.js' => false,
            'jquery-ui.js' => false,
            'jquery-ui.min.js' => false,
        );
        $this->renderPartial('location', compact('user'), false, true);
    }

    public function actionSaveLocation()
    {
        $country_id = Yii::app()->request->getPost('country_id');
        $city_id = Yii::app()->request->getPost('city_id');
        $region_id = Yii::app()->request->getPost('region_id');

        $user = Yii::app()->user->getModel();
        $address = $user->address;
        $address->country_id = empty($country_id) ? null : $country_id;
        $address->region_id = empty($region_id) ? null : $region_id;
        $address->city_id = empty($city_id) ? null : $city_id;

        Yii::import('site.frontend.widgets.user.*');
        if ($address->save()) {
            $response = array(
                'status' => true,
                'weather' => $this->widget('WeatherWidget', array('user' => $user), true),
                'main' => $this->widget('LocationWidget', array('user' => $user), true),
                'location' => $user->address->getFlag(true, 'span') . '<span class="location-tx">' . $user->address->getUserFriendlyLocation() . '</span>',
                'mapsLocation' => $address->fullTextLocation()
            );
            UserAction::model()->add($user->id, UserAction::USER_ACTION_ADDRESS_UPDATED, array('model' => $address));
        } else {
            $response = array(
                'status' => false,
                'full' => ($user->score->full == 0) ? false : true
            );
        }

        echo CJSON::encode($response);
    }

    public function actionRegionIsCity()
    {
        $id = Yii::app()->request->getPost('id');
        if (empty($id))
            Yii::app()->end();
        $region = GeoRegion::model()->findByPk($id);
        echo CJSON::encode(array('status' => $region->isCity()));
    }

    /**
     * @param int $id model id
     * @return GeoRusSettlement
     * @throws CHttpException
     */
    public function loadSettlment($id)
    {
        $model = GeoRusSettlement::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
