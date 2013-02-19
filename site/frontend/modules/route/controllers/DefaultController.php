<?php

class DefaultController extends HController
{
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
            $points = $route->getIntermediatePoints();
            $this->render('page', compact('route', 'texts', 'points'));
        }
    }

    public function actionGetRouteId()
    {
        $city_from = GeoCity::getCityByCoordinates(Yii::app()->request->getPost('city_from_lat'), Yii::app()->request->getPost('city_from_lng'));
        $city_to = GeoCity::getCityByCoordinates(Yii::app()->request->getPost('city_to_lat'), Yii::app()->request->getPost('city_to_lng'));

        if ($city_from != $city_to) {
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

    public function actionTest()
    {
        $c = new GoogleMapsGeoCode;
        $city = $c->getCityByCoordinates(50.402830, 30.684730);
        if (isset($city->id))
            echo $city->id;
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