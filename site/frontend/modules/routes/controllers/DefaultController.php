<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 08/08/14
 * Time: 10:06
 */

class DefaultController extends LiteController
{
    public $layout = '//layouts/lite/main';

    protected function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $cs = Yii::app()->clientScript;
            $cs->registerPackage('lite_routes');
            $cs->useAMD = true;
            return true;
        }
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionCities($letter)
    {
        $dp = Route::getCitiesListDp($letter);
        $this->render('cities', compact('dp', 'letter'));
    }

    public function actionCity($cityId)
    {
        $city = GeoCity::model()->with('region')->findByPk($cityId);
        if ($city === null) {
            throw new CHttpException(404);
        }

        $dp = Route::getCityDp($cityId);
        $this->render('city', compact('dp', 'city'));
    }
} 