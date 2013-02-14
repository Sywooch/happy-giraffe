<?php

class DefaultController extends HController
{
    public function actionIndex($id = null)
    {
        if (empty($id)) {
            $this->render('index');
        } else {
            $route = $this->loadModel($id);
            PageView::model()->incViewsByPath($route->url);

            $texts = $route->getTexts();
            $this->render('page', compact('route', 'texts'));
        }
    }

    public function actionGetRouteId()
    {
        $city_from = GeoCity::getCityByCoordinates(Yii::app()->request->getPost('city_from_lat'), Yii::app()->request->getPost('city_from_lng'));
        $city_to = GeoCity::getCityByCoordinates(Yii::app()->request->getPost('city_to_lat'), Yii::app()->request->getPost('city_to_lng'));

        $route = Route::model()->findByAttributes(array('city_from_id' => $city_from->id, 'city_to_id' => $city_to->id));
        if ($route === null){
            //create new route
            $route = Route::createNewRoute($city_from, $city_to);
        }

        echo CJSON::encode(array('status' => true, 'id' => $route->id));
    }

    public function actionTest()
    {
        $c = new GoogleMapsGeoCode;
        $city = $c->getCityByCoordinates(50.402830,30.684730);
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