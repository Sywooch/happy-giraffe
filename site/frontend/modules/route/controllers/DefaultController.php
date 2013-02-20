<?php

class DefaultController extends HController
{

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + SendEmail, getRouteId'
        );
    }

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
            ),
        );
    }

    public function actionIndex($id = null)
    {
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        if (empty($id)) {
            $this->render('index');
        } else {
            $route = $this->loadModel($id);
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

    public function actionTest()
    {
//        $city = GeoCity::model()->findByPk(14798);
//        echo $city->getFullName()."<br>";
//        $parser = new GoogleCoordinatesParser;
//        $parser->city = $city;
//        $parser->parseCity();
//
//        var_dump($parser->coordinates->attributes);

//        $r = GoogleRouteParser::getUrl(Route::model()->findByPk(2634));
//        var_dump($r);

        $p = new GoogleRouteParser;
        $p->parseRoute(Route::model()->findByPk(2634));
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
            if ($return_route !== null){
                $return_route->delete();
                $route->createReturnRoute();
            }
        }

        $this->redirect($this->createUrl('/route/default/', array('id'=>$route->id)));
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