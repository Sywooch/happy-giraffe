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

        echo $city_from->id.' - '.$city_to->id;
        //Yii::app()->end();

        $route = Route::model()->findByAttributes(array('city_from_id' => $city_from->id, 'city_to_id' => $city_to->id));
        if ($route === null){
            //create new route
            Route::createNewRoute($city_from, $city_to);
        }else
            echo CJSON::encode(array('status' => true, 'id' => $route->id));
    }

    public function actionGetRoutes()
    {
        $data = $_POST['data'];
        foreach ($data as $route) {
            //echo $route['t1_lat'].', '.$route['t1_lng']."\n";
            echo Yii::app()->geoCode->getObjectNameByCoordinates($route['t1_lat'], $route['t1_lng']) . '<br>';
        }
    }

    public function actionTest()
    {
        $parser = new RosneftParser;
        $parser->start();
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