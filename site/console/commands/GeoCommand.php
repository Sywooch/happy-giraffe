<?php
/**
 * Author: alexk984
 * Date: 14.05.2012
 */
class GeoCommand extends CConsoleCommand
{
    public function beforeAction($action){
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

    public function actionParseRoutes($debug = false)
    {
        $parser = new RouteSeasonParser();
        $parser->start($debug);
    }

    public function actionCoordinates()
    {
        $parser = new GoogleCoordinatesParser(false, true);
        $parser->start();
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

    public function actionCopyCities()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = GeoCity::model()->findAll($criteria);

            foreach ($models as $model) {
                $m = new SeoCityCoordinates;
                $m->city_id = $model->id;
                $m->save();
            }

            $criteria->offset += 100;
        }
    }

    public function actionRosneft()
    {
        $parser = new RosneftParser;
        $parser->start();
    }

    public function actionDecl(){
        $c = new CityDeclension();

        $cities = GeoCity::model()->findAll('type="г"');
        foreach($cities as $city){
            list($n1, $n2) = $c->getDeclensions($city->name);
            $city->name_from = $n1;
            $city->name_between = $n2;
            $city->update(array('name_from', 'name_between'));
        }
    }
}