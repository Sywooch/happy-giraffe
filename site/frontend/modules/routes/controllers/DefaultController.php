<?php

class DefaultController extends ServiceController
{
    public $service_id = 26;

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + SendEmail, getRouteId'
        );
    }

    /**
     * @sitemap dataSource=sitemap
     */
    public function actionIndex($id = null)
    {
        $this->layout = '//layouts/community';
        $this->meta_title = 'Составь маршрут для автомобиля';

        if (empty($id)) {
            $this->render('index');
        } else {
            $route = $this->loadModel($id);
            if ($route->wordstat_value < Route::WORDSTAT_LIMIT)
                Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

            if ($route->status != Route::STATUS_ROSNEFT_FOUND && $route->status != Route::STATUS_GOOGLE_PARSE_SUCCESS)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            PageView::model()->incViewsByPath($route->url);

            $texts = $route->getTexts();
            $this->meta_title = $texts['title'];
            $this->meta_description = $texts['description'];
            $this->meta_keywords = $texts['keywords'];
            $points = $route->getIntermediatePoints();
            $this->render('view', compact('route', 'texts', 'points'));
        }
    }

    public function actionGetRouteId()
    {
        $city_from = GeoCity::getCityByCoordinates(Yii::app()->request->getPost('city_from_lat'), Yii::app()->request->getPost('city_from_lng'));
        $city_to = GeoCity::getCityByCoordinates(Yii::app()->request->getPost('city_to_lat'), Yii::app()->request->getPost('city_to_lng'));

        if ($city_from->id != $city_to->id) {
            $route = Route::model()->findByAttributes(array('city_from_id' => $city_from->id, 'city_to_id' => $city_to->id));
            if ($route !== null && ($route->status == Route::STATUS_ROSNEFT_FOUND || $route->status == Route::STATUS_GOOGLE_PARSE_SUCCESS)) {
                echo CJSON::encode(array('status' => true, 'id' => $route->id));
                Yii::app()->end();
            }
        }
        echo CJSON::encode(array('status' => false));
    }

    public function actionCreateRoute(){
        $city_from = GeoCity::getCityByCoordinates(Yii::app()->request->getPost('city_from_lat'), Yii::app()->request->getPost('city_from_lng'));
        $city_to = GeoCity::getCityByCoordinates(Yii::app()->request->getPost('city_to_lat'), Yii::app()->request->getPost('city_to_lng'));

        if ($city_from->id != $city_to->id) {
            $route = Route::model()->findByAttributes(array('city_from_id' => $city_from->id, 'city_to_id' => $city_to->id));
            if ($route === null) {
                //create new route
                $route = Route::createNewRoute($city_from, $city_to);
            }

            if ($route->status == Route::STATUS_ROSNEFT_FOUND || $route->status == Route::STATUS_GOOGLE_PARSE_SUCCESS) {
                echo CJSON::encode(array('status' => true, 'id' => $route->id));
                Yii::app()->end();
            }
        }

        echo CJSON::encode(array('status' => false));
    }

    public function actionSendEmail()
    {
        $model = new SendRoute();
        $model->attributes = $_POST['SendRoute'];
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if ($model->validate()) {
            $model->send();
            echo CJSON::encode(array('status' => true));
        } else {
            var_dump($model->getErrors());
        }
    }

    public function actionReparseGoogle($id)
    {
        $route = $this->loadModel($id);
        $success = GoogleRouteParser::parseRoute($route);
        if ($success) {
            $return_route = Route::model()->findByAttributes(array(
                'city_from_id' => $route->city_to_id,
                'city_to_id' => $route->city_from_id
            ));
            if ($return_route !== null) {
                $return_route->delete();
                $route->createReturnRoute();
            }
        }

        $this->redirect($this->createUrl('/routes/default/', array('id' => $route->id)));
    }

    public function sitemap($param)
    {
//        $models = Yii::app()->db->createCommand()
//            ->select('id')
//            ->from(Route::model()->tableName())
//            ->where('(status = 2 OR status=4) AND id > ' . (40000 * ($param - 1)) . ' AND id <=' . (40000 * $param))
//            ->queryColumn();
//
        $models = Yii::app()->db->createCommand()
            ->select('id')
            ->from(Route::model()->tableName())
            ->where(array('and', 'wordstat_value >= '.Route::WORDSTAT_LIMIT, array('in', 'status', array(Route::STATUS_ROSNEFT_FOUND, Route::STATUS_GOOGLE_PARSE_SUCCESS))))
            ->queryColumn();

        $data = array();
        if ($param == 1)
            $data [] = array(
                'params' => array(
                ),
                'changefreq' => 'weekly',
            );
        foreach ($models as $model) {
            $data[] = array(
                'params' => array(
                    'id' => $model,
                ),
                'changefreq' => 'weekly',
            );
        }

        return $data;
    }

    /**
     * @param int $id model id
     * @return Route
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Route::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}