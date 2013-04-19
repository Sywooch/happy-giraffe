<?php
/**
 * Author: alexk984
 * Date: 14.05.2012
 */
class GeoCommand extends CConsoleCommand
{
    public function beforeAction($action)
    {
        Yii::import('site.frontend.modules.geo.components.*');
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.modules.route.models.*');
        Yii::import('site.frontend.modules.route.components.*');
        Yii::import('site.seo.components.*');
        Yii::import('site.seo.models.*');

        return true;
    }

    public function actionFormRoutes()
    {
        $cities = GeoCity::model()->findAll('type="г"');
        echo count($cities);
        for ($i = 0; $i < count($cities); $i++) {
            for ($j = 0; $j < count($cities); $j++)
                if ($cities[$i]->id != $cities[$j]->id) {
                    $model = new RouteParsing();
                    $model->city_from_id = $cities[$i]->id;
                    $model->city_to_id = $cities[$j]->id;
                    $model->save();
                }

            if ($i % 10 == 0)
                echo $i . "\n";
        }
    }

    public function actionGoogleRoute()
    {
        time_nanosleep(rand(0, 10), rand(0, 1000000000));

        $parser = new GoogleRouteParser();
        $parser->startParse();
    }

    public function actionCopyRoutes()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->offset = 0;
        $criteria->condition = 'wordstat > 0';

        $models = array(0);
        while (!empty($models)) {
            $models = RouteParsing::model()->findAll($criteria);
            foreach ($models as $model) {
                $route = new Route();
                $route->city_from_id = $model->city_from_id;
                $route->city_to_id = $model->city_to_id;
                $route->wordstat_value = $model->wordstat;
                $route->save();
            }

            $criteria->offset += 1000;
        }
    }

    public function actionShowCounts()
    {
        CRouteLinking::model()->showCounts();
    }

    public function actionReturnRoutes()
    {
        for ($i = 1; $i <= 71008; $i++) {
            $r = Route::model()->findByPk($i);
            if ($r !== null)
                $r->createReturnRoute();
        }
    }

    public function actionLinks()
    {
        $l = new CRouteLinking;
        $l->start();
    }

    public function actionLinks2()
    {
        $l = new CRouteLinking;
        $l->startStage2();
    }

    public function actionCityCoordinates()
    {
        $parser = new GoogleCoordinatesParser(false, true);
        $parser->start();
    }

    public function actionRosneft()
    {
        $parser = new RosneftParser;
        $parser->start();
    }

    public function actionTest()
    {
        $cities = file_get_contents('/home/giraffe/cities2.txt');
        $cities = explode("\n", $cities);

        foreach($cities as $city){
            $city = trim($city);
            if (empty($city))
                continue;

            $model = Keyword::model()->findByAttributes(array('name' => $city));
            if ($model === null){
                $model = new Keyword;
                $model->name = $city;
                $model->save();
            }
        }
    }
}