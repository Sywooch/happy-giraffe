<?php

class DefaultController extends HController
{
	public function actionIndex()
	{
        Yii::app()->geoCode->getCityByCoordinates(48.71928, 44.50657000000001);
        //Yii::app()->geoCode->getCityByCoordinates(49.546765,45.074587);
//        GoogleMapsGeoCode::getCityByCoordinates(55.802801,37.737093);
        //CRouteLinking::model()->add(16586);
	}

    public function actionTest()
    {
        $this->render('index');
    }

    public function actionMap(){
        $this->render('map');
    }

    public function actionGetRoutes()
    {
        $data = $_POST['data'];
        foreach($data as $route){
            //echo $route['t1_lat'].', '.$route['t1_lng']."\n";
            echo Yii::app()->geoCode->getObjectNameByCoordinates($route['t1_lat'],$route['t1_lng']).'<br>';
        }
    }
}