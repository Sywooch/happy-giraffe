<?php

class TileController extends HController
{
    public function actionIndex()
    {
        $this->pageTitle = 'Расчет плитки для ванной комнаты';
        $basePath = Yii::getPathOfAlias('repair') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'tile' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile($baseUrl . '/style.css', 'all');
        $this->render('index', array('tileModel' => new TileForm()));
    }

    public function actionCalculate()
    {
        if (isset($_POST['TileForm'])) {
            $model = new TileForm();
            $model->attributes = $_POST['TileForm'];
            $validationResult = CActiveForm::validate($model);
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'tile-calculate-form') {
                echo $validationResult;
                Yii::app()->end();
            }
            $this->renderPartial('result', array('result' => $model->calculate()));
        }
    }
}