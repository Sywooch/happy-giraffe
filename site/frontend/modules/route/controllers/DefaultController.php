<?php

class DefaultController extends HController
{
    public function actionIndex($id = null)
    {
        if (empty($id)) {

        } else {
            $route = $this->loadModel($id);
            $texts = $route->getTexts();
            $this->render('page', compact('route', 'texts'));
        }
    }

    public function actionMap()
    {
        $this->render('map');
    }

    public function actionGetRoutes()
    {
        $data = $_POST['data'];
        foreach ($data as $route) {
            //echo $route['t1_lat'].', '.$route['t1_lng']."\n";
            echo Yii::app()->geoCode->getObjectNameByCoordinates($route['t1_lat'], $route['t1_lng']) . '<br>';
        }
    }

    public function actionTest(){
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