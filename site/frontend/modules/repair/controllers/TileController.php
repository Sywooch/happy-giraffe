<?php

class TileController extends Controller
{
    public function actionIndex()
    {
        $this->pageTitle = 'Расчет плитки для ванной комнаты';
        $basePath = Yii::getPathOfAlias('repair') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'tile' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile($baseUrl . '/style.css', 'all');
        Yii::app()->user->setState('repairTileAreas', array());
        $this->render('index', array('tileModel' => new TileForm(), 'area' => new TileAreaForm()));
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

    public function actionAreaAdd()
    {
        if (isset($_POST['TileAreaForm'])) {
            $model = new TileAreaForm();
            $model->attributes = $_POST['TileAreaForm'];
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'area-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            $model->validate();
            $areas = Yii::app()->user->getState('repairTileAreas');
            $areas[] = array('title' => $model->title, 'height' => $model->height, 'width' => $model->width);
            Yii::app()->user->setState('repairTileAreas', $areas);
            $this->renderPartial('emptyarea', array('areas' => $areas));
        }
    }

    public function actionAreaDelete($id)
    {
        $areas = Yii::app()->user->getState('repairTileAreas');
        if (isset($areas[$id]))
            unset($areas[$id]);
        Yii::app()->user->setState('repairTileAreas', $areas);
        $this->renderPartial('emptyarea', array('areas' => $areas));
    }
}